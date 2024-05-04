
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">

<div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f8f8f8; border-radius: 5px;">

    <h2>Leave Application!</h2>

    <p>Dear {{ $user->name }},</p>

    <p>We are excited to welcome you to our community. Thank you for joining us!</p>

    <p>Your Leave application is:</p>

    <ul>
        @if ($leave->status == 2)
            <li><strong>Status:</strong> Pending</li>
        @elseif ($leave->status == 4)
            <li><strong>Status:</strong> Approved</li>
        @elseif ($leave->status == 3)
            <li><strong>Status:</strong> Rejected</li>
        @elseif ($leave->status == 1)
            <li><strong>Status:</strong> Review</li>
        @elseif ($leave->status == 0)
            <li><strong>Status:</strong> Received</li>
        @else
            <li><strong>Status:</strong> Unknown</li>
        @endif
    </ul>

    <p>If you have any questions or need assistance, feel free to contact us.</p>

    <p>Thank you again for joining!</p>

    <p>Best regards,<br> Leave Application Team</p>

</div>

</body>
</html>
