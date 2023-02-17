<x-mail::message>
# Greetings, {{ $name }}

Your registration one-time password (OTP) is **{{ $otp }}**.

Please use this OTP within 5 minutes to complete your registration.

If you did not request this OTP, please ignore this email.

Thanks,<br>
The {{ config('app.name') }} Team
</x-mail::message>
