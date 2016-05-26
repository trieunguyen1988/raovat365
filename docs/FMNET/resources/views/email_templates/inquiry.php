Inquiry from <?php echo $inquiry['user_name']?><br>
<?php echo trans('common.MAIL_ADDRESS').': '.$inquiry['email']?><br>
<?php echo trans('inquiry.INQUIRY_SUBJECT').': '.$inquiry['subject']?><br>
<?php echo trans('inquiry.INQUIRY_CONTENT').':'?><br>
<?php echo nl2br($inquiry['inquiry_content'])?>
