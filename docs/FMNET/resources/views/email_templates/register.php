Welcome <?php echo $user->email?><br>
Please click <a href="<?php echo Request::root().'/user/register?url='. Crypt::encrypt($user->uuid).'&u='.urlencode(Crypt::encrypt($user->email))?>">here</a> to complete the registration<br>

