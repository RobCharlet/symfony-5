<?php


namespace App\MessageHandler;


use App\Message\CommentMessage;
use App\Repository\CommentRepository;
use App\SpamChecker;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class CommentMessageHandler implements MessageHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var SpamChecker
     */
    private $spamChecker;
    /**
     * @var CommentRepository
     */
    private $commentRepository;
    /**
     * @var MessageBusInterface
     */
    private $bus;
    /**
     * @var WorkflowInterface
     */
    private $workflow;
    /**
     * @var null|LoggerInterface
     */
    private $logger;

    /**
     * CommentMessageHandler constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param SpamChecker            $spamChecker
     * @param CommentRepository      $commentRepository
     * @param MessageBusInterface    $bus
     * @param WorkflowInterface      $commentStateMachine
     * @param LoggerInterface|null   $logger
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        SpamChecker $spamChecker,
        CommentRepository $commentRepository,
        MessageBusInterface $bus,
        WorkflowInterface $commentStateMachine,
        LoggerInterface $logger = null
    )
    {
        $this->entityManager = $entityManager;
        $this->spamChecker = $spamChecker;
        $this->commentRepository = $commentRepository;
        $this->bus = $bus;
        $this->workflow = $commentStateMachine;
        $this->logger = $logger;
    }

    public function __invoke(CommentMessage $message)
    {
        $comment = $this->commentRepository->find($message->getId());

        if (!$comment) {
            return;
        }

        // If the accept transition is available for the comment in the message, check for spam
        if ($this->workflow->can($comment, 'accept')) {
            $score = $this->spamChecker->getSpamScore($comment, $message->getContext());
            $transition = 'accept';

            // Depending on the outcome, choose the right transition to apply
            if (2 === $score) {
                $transition = 'reject_spam';
            } elseif (1 === $score) {
                $transition = 'might_be_spam';
            }

            // Call apply() to update the Comment via a call to the setState() method
            $this->workflow->apply($comment, $transition);

            // Call flush() to commit the changes to the database
            $this->entityManager->flush();

            // Re-dispatch the message to allow the workflow to transition again
            $this->bus->dispatch($message);
        }
        //Will be handled by admin later
        else if (
            $this->workflow->can($comment, 'publish') || $this->workflow->can($comment, 'publish_ham')
        ) {
            $this->workflow->apply(
                $comment,
                $this->workflow->can($comment, 'publish') ? 'publish' : 'publish_ham'
            );
            $this->entityManager->flush();
        }


        else if ($this->logger) {
            $this->logger->debug('Dropping comment message', ['comment' => $comment->getId(), 'state' => $comment->getState()]);
        }

        $this->entityManager->flush();
    }
}