<?php

define('ACCOUNT_PROFILE_EDIT', 'Edit Account Profile');
define('ACCOUNT_PROFILE_EDIT_CN', '修改帐号资料');

function EditProfileForm($strSubmit)
{
    if ($strSubmit == ACCOUNT_PROFILE_EDIT_CN)
    {
        $arColumn = array('名字', '电话', '地址', '网址', '签名档', '接收palmmicro邮件', '否', '是');
    }
    else
    {
        $arColumn = array('Name', 'Phone', 'Address', 'Web', 'Signature', 'Receive palmmicro email', 'No', 'Yes');
    }

    $strMemberId = AcctIsLogin();
    $strPassQuery = UrlPassQuery();
    
	$strYesChecked = '';
	$strNoChecked = '';
	if ($member = SqlGetMemberById($strMemberId))
	{
		if ($member['status'] == '1')          $strNoChecked = 'checked';
		else if ($member['status'] == '2')    $strYesChecked = 'checked';
	}
	
	$strName = '';
	$strPhone = '';
	$strAddress = '';
	$strWeb = '';
	$strSignature = '';
	if ($profile = SqlGetProfileByMemberId($strMemberId))
	{
		$strName = $profile['name'];
		$strPhone = $profile['phone'];
		$strAddress = $profile['address'];
		$strWeb = $profile['web'];
		$strSignature = $profile['signature'];
	}
    
	echo <<< END
<form id="updateForm" name="updateForm" method="post" action="/account/php/_submitprofile.php$strPassQuery">
  <table width="640" border="0" align="left" cellpadding="2" cellspacing="0">
    <tr>
      <td><b>{$arColumn[0]}</b></td>
      <td><input name="name" value="$strName" type="text" maxlength="64" class="textfield" id="name" /></td>
    </tr>
    <tr>
      <td><b>{$arColumn[1]}</b></td>
      <td><input name="phone" value="$strPhone" type="text" maxlength="64" class="textfield" id="phone" /></td>
    </tr>
    <tr>
      <td><b>{$arColumn[2]}</b></td>
      <td><input name="address" value="$strAddress" type="text" size="64" maxlength="128" class="textfield" id="address" /></td>
    </tr>
    <tr>
      <td><b>{$arColumn[3]}</b></td>
      <td><input name="web" value="$strWeb" type="text" size="64" maxlength="128" class="textfield" id="web" /></td>
    </tr>
    <tr>
      <td><b>{$arColumn[4]}</b></td>
	  <td><textarea name="signature" rows="6" cols="64" id="signature">$strSignature</textarea></td>
    </tr>
    <tr>
      <td><b>{$arColumn[5]}</b></td>      
      <td><input name="status" value="1" type=radio $strNoChecked>{$arColumn[6]}&nbsp;&nbsp;<input name="status" value="2" type=radio $strYesChecked>{$arColumn[7]}</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="submit" value="$strSubmit" /></td>
    </tr>
  </table>
</form>
END;
}

?>
