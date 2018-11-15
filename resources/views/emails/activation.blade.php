<!-- Template -->
<html>
<body>
    <table border="0" cellpadding="5px" cellspacing="0" align="left" width="640px">
        <tr>
            <td colspan="4">Dear {{$data['username']}},</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-bottom:20px;">Thank you for signing up to the Air Aroma Store. Please follow this link to activate your account. <br /> {{$data['activationlink']}}</td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top:20px;">
                Best Regards,<br />
                Air Aroma<br />
                <a href="<?= websiteUrl();?>" style=""><?= websiteUrl();?></a>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top:20px;">
                This transmission may be privileged and may contain confidential information intended only for the person(s) named above. Any other distribution, re-transmission, copying or disclosure is strictly prohibited. If you have received this transmission in error, please notify us immediately by telephone or email, and delete this file/message from your system.     
            </td>
        </tr>
    </table>
</body>
</html>
<!-- TemplateEnd -->
