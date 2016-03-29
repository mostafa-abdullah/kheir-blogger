Click here to reset your password: <a href="{{ $link = url('password_organization/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
