<!doctype html>
<html lang="en">
  <body style="font-family: Arial, sans-serif; line-height: 1.4;">
    <h2>Password reset</h2>

    <p>Your verification code is:</p>

    <div style="font-size: 26px; font-weight: bold; letter-spacing: 3px; margin: 12px 0;">
      {{ $code }}
    </div>

    <p>This code expires in 15 minutes.</p>

    @if(!empty($link))
      <p>You can also open this link:</p>
      <p><a href="{{ $link }}">{{ $link }}</a></p>
    @endif

    <p>If you did not request this, you can ignore this email.</p>
  </body>
</html>
