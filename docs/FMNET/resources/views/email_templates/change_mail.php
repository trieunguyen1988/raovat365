Hello <?php echo $user->user_name?><br>
Please click <a href="<?php echo Request::root().'/user/cmail?ui='. Crypt::encrypt($user->user_id).'&te='.urlencode(Crypt::encrypt($user->temp_email))?>">here</a> to complete changing email<br>
