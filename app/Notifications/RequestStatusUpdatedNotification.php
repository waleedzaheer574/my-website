<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestStatusUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $requestType,
        public string $requestTitle,
        public string $event,
        public ?string $reference = null,
        public ?string $actionUrl = null,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $meta = $this->meta();

        return (new MailMessage)
            ->subject($meta['title'].' | Multitechwave')
            ->greeting('Hi '.$notifiable->name.',')
            ->line($meta['message'])
            ->line('Request: '.$this->requestTitle)
            ->when($this->reference, fn (MailMessage $message) => $message->line('Reference: '.$this->reference))
            ->action($meta['action_label'], $this->actionUrl ?: route('user.dashboard'))
            ->line('Thank you for choosing Multitechwave.');
    }

    public function toArray(object $notifiable): array
    {
        $meta = $this->meta();

        return [
            'request_type' => $this->requestType,
            'request_title' => $this->requestTitle,
            'reference' => $this->reference,
            'event' => $this->event,
            'type' => $meta['type'],
            'icon' => $meta['icon'],
            'title' => $meta['title'],
            'message' => $meta['message'],
            'action_label' => $meta['action_label'],
            'action_url' => $this->actionUrl ?: route('user.dashboard'),
        ];
    }

    public function whatsappMessage(): string
    {
        $meta = $this->meta();

        return 'Multitechwave: '.$meta['message'].' Request: '.$this->requestTitle.'.';
    }

    protected function meta(): array
    {
        return self::eventDefinitions()[$this->event] ?? [
            'type' => 'update',
            'icon' => 'far fa-bell',
            'title' => 'Request Updated',
            'message' => 'Your request has a new update.',
            'action_label' => 'Open Dashboard',
        ];
    }

    public static function eventDefinitions(): array
    {
        return [
            'submitted' => [
                'type' => 'info',
                'icon' => 'far fa-file-alt',
                'title' => 'New Request Submitted',
                'message' => 'Your service request has been submitted successfully.',
                'action_label' => 'View Request',
            ],
            'pending_review' => [
                'type' => 'pending',
                'icon' => 'far fa-clock',
                'title' => 'Request Under Review',
                'message' => 'Our team is reviewing your request and requirements.',
                'action_label' => 'Track Request',
            ],
            'proposal_sent' => [
                'type' => 'proposal',
                'icon' => 'far fa-file-pdf',
                'title' => 'Proposal Sent',
                'message' => 'A new proposal and quotation has been shared with you.',
                'action_label' => 'View Proposal',
            ],
            'in_discussion' => [
                'type' => 'discussion',
                'icon' => 'far fa-comments',
                'title' => 'Deal Discussion Started',
                'message' => 'Project scope and pricing discussion is currently in progress.',
                'action_label' => 'View Details',
            ],
            'deal_in_progress' => [
                'type' => 'discussion',
                'icon' => 'far fa-comments',
                'title' => 'Deal In Progress',
                'message' => 'Project scope and pricing discussion is currently in progress.',
                'action_label' => 'View Details',
            ],
            'approved' => [
                'type' => 'success',
                'icon' => 'far fa-check-circle',
                'title' => 'Project Approved',
                'message' => 'Your project has been approved successfully.',
                'action_label' => 'Open Project',
            ],
            'in_progress' => [
                'type' => 'progress',
                'icon' => 'fas fa-rocket',
                'title' => 'Project Started',
                'message' => 'Development work has officially started on your project.',
                'action_label' => 'Track Progress',
            ],
            'progress_updated' => [
                'type' => 'update',
                'icon' => 'fas fa-chart-line',
                'title' => 'Project Progress Updated',
                'message' => 'Your project progress has been updated.',
                'action_label' => 'View Progress',
            ],
            'files_uploaded' => [
                'type' => 'file',
                'icon' => 'far fa-folder-open',
                'title' => 'Files Uploaded',
                'message' => 'New project files and deliverables have been uploaded.',
                'action_label' => 'View Files',
            ],
            'client_message_received' => [
                'type' => 'message',
                'icon' => 'far fa-comment-dots',
                'title' => 'Client Message Received',
                'message' => 'You have received a new message regarding your project.',
                'action_label' => 'Open Message',
            ],
            'testing_review' => [
                'type' => 'qa',
                'icon' => 'fas fa-vial',
                'title' => 'Project Testing Started',
                'message' => 'Your project is currently under testing and quality review.',
                'action_label' => 'View Status',
            ],
            'client_review' => [
                'type' => 'review',
                'icon' => 'far fa-eye',
                'title' => 'Client Review Requested',
                'message' => 'Please review the latest project update and share your feedback.',
                'action_label' => 'Review Update',
            ],
            'completed' => [
                'type' => 'completed',
                'icon' => 'fas fa-award',
                'title' => 'Project Completed',
                'message' => 'Your project has been completed successfully and delivered.',
                'action_label' => 'View Delivery',
            ],
        ];
    }
}
