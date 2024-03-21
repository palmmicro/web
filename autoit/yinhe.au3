#cs
	Title:   		拖拉机自动化
	Filename:  		yinhe.au3
	Description: 	拖拉机账户自动申购、卖出、撤单、逆回购和银证转账回银行。
					https://palmmicro.com/woody/res/autotractorcn.php
	Author:   		Woody Lin

	This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
#ce

#include <ButtonConstants.au3>
#include <EditConstants.au3>
#include <GUIConstantsEx.au3>
#include <GUIListBox.au3>
#include <ListViewConstants.au3>
#include <ProgressConstants.au3>
#include <StaticConstants.au3>
#include <WindowsConstants.au3>

#include <WinAPI.au3>
;#include <SendMessage.au3>
;#include <Misc.au3>
#include <Array.au3>
#include <GuiTreeView.au3>
#include <GuiListView.au3>
#include <Date.au3>

#include <yinheaccounts.au3>

const $YINHE = 0
const $HUABAO = 1

#cs
#include <Tesseract.au3>

Func _getVerifyCode($iLeft, $iTop, $iRight, $iBottom)
	$strCode = _TesseractScreenCapture(0, '', 1, 2, $iLeft, $iTop, $iRight, $iBottom)
	If $strCode == '' Then
		$strCode = '0'
	Else
		$strCode = StringReplace($strCode, 'Z', '2')
		If StringLen($strCode) > 4 Then $strCode = StringLeft($strCode, 4)
	EndIf
	Return $strCode
EndFunc
#ce

Func _CtlDebug($idDebug, $str)
	$strDebug = _NowTime(5) & " " & $str
	ConsoleWrite($strDebug & @CRLF)

   _GUICtrlListBox_BeginUpdate($idDebug)
   _GUICtrlListBox_InsertString($idDebug, $strDebug, 0)
   _GUICtrlListBox_EndUpdate($idDebug)
EndFunc

Func _CtlSendPassword($hWnd, $idDebug, $strControl, $strPassword)
	$strDebug = '模拟键盘输入密码"'
	For $i = 1 to StringLen($strPassword)
		$strDebug &= '*'
	Next

	_CtlDebug($idDebug, $strDebug & '"')
	ControlFocus($hWnd, '', $strControl)
	Send($strPassword)
	Sleep(1000)
EndFunc

Func _CtlSendString($hWnd, $idDebug, $strControl, $str)
	If ControlCommand($hWnd, '', $strControl, 'IsEnabled') == 0 Then
		_CtlDebug($idDebug, '控件"' & $strControl & '"处于无法输入状态，"' & $str & '"被忽略。')
		Return False
	EndIf

	$strDebug = '模拟在控件输入"' & $str & '"......'
	_CtlDebug($idDebug, $strDebug)
;	$iCount = 0
;	While $str <> ControlGetText($hWnd, '', $strControl)
		ControlFocus($hWnd, '', $strControl)
;		Send('{BACKSPACE}')
		ControlSend($hWnd, '', $strControl, $str)
;		ControlSetText($hWnd, '', $strControl, $str)
		Sleep(1000)
;		$iCount += 1
;		If $iCount == 50 Then
;			_CtlDebug($idDebug, $strDebug & '在5秒后放弃')
;			ExitLoop
;		EndIf
;	WEnd
;	If $iCount <> 0 Then Return True
;	Return False
	Return True
EndFunc

Func _CtlSetText($hWnd, $idDebug, $strControl, $strText)
	$strDebug = '写入"' & $strText & '"......'
	_CtlDebug($idDebug, $strDebug)
	$iCount = 0
	While $strText <> ControlGetText($hWnd, '', $strControl)
		ControlSetText($hWnd, '', $strControl, $strText)
		Sleep(100)
		$iCount += 1
		If $iCount == 50 Then
			_CtlDebug($idDebug, $strDebug & '在5秒后放弃')
			ExitLoop
		EndIf
	WEnd
EndFunc

Func _CtlSelectString($hWnd, $idDebug, $strControlID, ByRef $iSel)
	ControlCommand($hWnd, '', $strControlID, 'SetCurrentSelection', $iSel)
	If @error Then Return False
	Sleep(2000)
	$iSel += 1
	$str = ControlCommand($hWnd, '', $strControlID, 'GetCurrentSelection')
	_CtlDebug($idDebug, '选择第' & String($iSel) & '个账户"' & $str & '"')
	Return $str
EndFunc

Func _CtlClickButton($hWnd, $idDebug, $strButton)
	_CtlDebug($idDebug, '模拟点击按钮"' & $strButton & '"')
	WinActivate($hWnd)
	ControlClick($hWnd, '', '[CLASS:Button; TEXT:' & $strButton & ']')
	Sleep(1000)
EndFunc

Func _CtlCheckButton($hWnd, $idDebug, $strControlID)
	If ControlCommand($hWnd, '', $strControlID, 'IsChecked') == 0 Then
		ControlClick($hWnd, '', $strControlID)
	EndIf
EndFunc

Func _yinheCloseMsgDlg($idDebug)
	$hMsgWnd = WinGetHandle('消息标题', '今日不再提示')
	If $hMsgWnd <> 0 Then
		_CtlCheckButton($hMsgWnd, $idDebug, 'Button4')
		_CtlClickButton($hMsgWnd, $idDebug, '关闭')
	EndIf
EndFunc

Func _closeNewDlg($idDebug)
	_DlgClose($idDebug, '海王星条件单')
	_DlgClose($idDebug, '海王星网格交易')
	_DlgClose($idDebug, '股票、可转债及可交换债')
EndFunc

Func _DlgClickButton($idDebug, $strTitle, $strButton)
;	$hDlgWnd = WinWait($strTitle, $strButton, 5)
	$iCount = 0
	While $iCount < 5
		$hDlgWnd = WinWait($strTitle, $strButton, 1)
		If $hDlgWnd <> 0 Then ExitLoop
		_closeNewDlg($idDebug)
		$iCount += 1
	WEnd

	If $hDlgWnd <> 0 Then
		_CtlClickButton($hDlgWnd, $idDebug, $strButton)
	Else
		_CtlDebug($idDebug, '5秒内没找到对话框"' & $strTitle & '"和按钮"' & $strButton & '"')
	EndIf
EndFunc

Func _DlgClose($idDebug, $strTitle, $strText = '关闭')
	$hNewWnd = WinGetHandle($strTitle, $strText)
	If $hNewWnd <> 0 Then
		WinClose($hNewWnd)	; _CtlClickButton($hNewWnd, $idDebug, '关闭')
		_CtlDebug($idDebug, '"' & $strText & '"对话框"' & $strTitle & '"')
		Return True
	EndIf
	Return False
EndFunc

Func _CtlGetText($hWnd, $idDebug, $strControl)
	_CtlDebug($idDebug, '反复读取"' & $strControl & '"的内容直到不为空字符串')
	Do
		Sleep(100)
		_closeNewDlg($idDebug)
		$str = ControlGetText($hWnd, '', $strControl)
	Until $str <> ''
	_CtlDebug($idDebug, $str)
	Return $str
EndFunc

Func _CtlWaitText($hWnd, $idDebug, $strControl, $strText)
	_CtlDebug($idDebug, '等待"' & $strText & '"的出现')
	Do
		Sleep(100)
	Until $strText == _CtlGetText($hWnd, $idDebug, $strControl)
EndFunc

Func _loginDlg($iSoftware, $idDebug, $strTitle, $strAccount, $strPassword)
	_CtlDebug($idDebug, '等待"' & $strTitle & '"成为活跃窗口')
	If ($iSoftware == $YINHE)	Then
		$strText = '默认PIN码'
	Else
		$strText = '自动安全码'
	EndIf
	$hWnd = WinWaitActive($strTitle, $strText)

	If StringLeft($strAccount, 1) == '0' Then $strAccount = StringTrimLeft($strAccount, 1)
	_CtlSetText($hWnd, $idDebug, 'Edit1', $strAccount)
	_CtlCheckButton($hWnd, $idDebug, 'Button6')		; 记住账号
	_CtlCheckButton($hWnd, $idDebug, 'Button11')	; 默认PIN码
	ControlCommand($hWnd, '', 'ComboBox4', 'SetCurrentSelection', 0)
	_CtlSendPassword($hWnd, $idDebug, 'AfxWnd421', $strPassword)

#cs
	$strControl = 'Edit2'
    $arWinPos = WinGetPos($hWnd)
	$arPos = ControlGetPos($hWnd, '', $strControl)
	$iLeft = $arWinPos[0] + $arPos[0] + $arPos[2] + 6
	$iTop = $arWinPos[1] + $arPos[1] + 1
	$iRight = $arWinPos[0] + $arWinPos[2] - 29
	$iBottom = $arWinPos[1] + $arPos[1] + $arPos[3] - 3

	$iCheckSum = PixelChecksum($iLeft, $iTop, $iRight, $iBottom)
	$iCount = 0
	Do
		If $iCount == 0 Then
			$strCode = _getVerifyCode($iLeft, $iTop, $iRight, $iBottom)
		Else
			$strCode = '9'
		EndIf

		_CtlSendString($hWnd, $idDebug, $strControl, $strCode)
;		_CtlClickButton($hWnd, $idDebug, '确认')
		ControlClick($hWnd, '', 'Button1')	;确认
		Do
			Sleep(100)
			$iNewCheckSum = PixelChecksum($iLeft, $iTop, $iRight, $iBottom)
			If $iNewCheckSum <> $iCheckSum	Then
				$iCheckSum = $iNewCheckSum
				$iCount = 0
				ExitLoop
			Else
				$iCount += 1
			EndIf
		Until $iCount == 10
		_closeNewDlg($idDebug)
		If _DlgClose($idDebug, '提示', '否') == True Then
			_CtlSendPassword($hWnd, $idDebug, 'AfxWnd421', $strPassword)
		EndIf
	Until ControlCommand($hWnd, '', 'ComboBox4', 'IsEnabled') == 0
#ce
	ControlClick($hWnd, '', 'Button1')	;确定

	$strMainTitle = '通达信网上交易V6'
	$iTimeOut = 1
	_CtlDebug($idDebug, '一定要找到窗口"' & $strMainTitle & '"和账号"' & $strAccount & '"......')
	While 1
		$hMainWnd = WinWait($strMainTitle, $strAccount, $iTimeOut)
		If $hMainWnd <> 0 Then
			WinActivate($hMainWnd)
			ExitLoop
		EndIf
		_yinheCloseMsgDlg($idDebug)
		_closeNewDlg($idDebug)
	WEnd
	Sleep(1000)
	_yinheCloseMsgDlg($idDebug)
	Return $hMainWnd
EndFunc

Func AppOpen($iSoftware, $idDebug, $strAccount, $strPassword)
	If ($iSoftware == $YINHE)	Then
		$strDir = '中国银河证券海王星独立交易'
		$strTitle = '通达信网上交易'
	Else
		$strDir = 'tc_hbzq'
		$strTitle = '华宝证券网上交易'
	EndIf
	$strPath = 'C:\' & $strDir & '\'
	Run($strPath & 'Tc.exe', $strPath)
	Return _loginDlg($iSoftware, $idDebug, $strTitle, $strAccount, $strPassword)
EndFunc

Func AppClose($hWnd, $idDebug)
	Sleep(1000)
	WinClose($hWnd)
	_DlgClickButton($idDebug, '退出确认', '退出系统')
EndFunc

Func _addSymbolSpecialKey($idDebug, $strSymbol)
	If $strSymbol == '160216' Or $strSymbol == '160416' Or $strSymbol == '160717' Or $strSymbol == '161125'  Or $strSymbol == '161126' Or $strSymbol == '161127' Or $strSymbol == '161226' Or $strSymbol == '163208' Or $strSymbol == '164824' Or $strSymbol == '164906' Then
		_DlgClickButton($idDebug, '请选择', '深圳股票')
	EndIf
EndFunc

Func _isShenzhenAccount($strAccount)
	If StringInStr($strAccount, '深') == 1 Then Return True
	Return False
EndFunc

Func _isShenzhenFundAccount($strAccount)
	If StringInStr($strAccount, '深A 05') == 1 Then Return True
	Return False
EndFunc

Func _isShanghaiAccount($strAccount)
	If StringInStr($strAccount, '沪') == 1 Then Return True
	Return False
EndFunc

Func _isShanghaiFundAccount($strAccount)
	If StringInStr($strAccount, '沪A F') == 1 Then Return True
	Return False
EndFunc

Func _isShenzhenLof($strSymbol)
	$iVal = Number($strSymbol)
	If $iVal >= 160000 And $iVal < 170000 Then return True
	return False
EndFunc

Func _isShanghaiLof($strSymbol)
	$iVal = Number($strSymbol)
	If $iVal >= 500000 And $iVal < 510000 Then return True
	return False
EndFunc

Func _isShenzhenSymbol($strSymbol)
	$iVal = Number($strSymbol)
	If $iVal < 200000 Then return True
	return False
EndFunc

Func _isShanghaiSymbol($strSymbol)
	$iVal = Number($strSymbol)
	If $iVal >= 200000 Then return True
	return False
EndFunc

Func _isAccountMatchSymbol($strAccount, $strSymbol)
	If (_isShenzhenAccount($strAccount) And _isShenzhenSymbol($strSymbol)) Or (_isShanghaiAccount($strAccount) And _isShanghaiSymbol($strSymbol)) Then	Return True
	Return False
EndFunc

Func _isSingleAccountSymbol($strSymbol)
	If $strSymbol == '161226' Or $strSymbol == '501225' Then	Return True
	return False
EndFunc

#cs
Func _TreeViewSelect($hWnd, $idDebug, $strControlID, $strItem)
	ControlTreeView($hWnd, '', $strControlID, 'Select', $strItem)
	$strDebug = '选择"' & $strItem & '"......'
	_CtlDebug($idDebug, $strDebug)
	$iCount = 0
	While $strItem <> ControlTreeView($hWnd, '', $strControlID, 'GetSelected', 0)
		Sleep(100)
		$iCount += 1
		If $iCount == 50 Then
			_CtlDebug($idDebug, $strDebug & '在5秒后放弃')
			ExitLoop
		EndIf
	WEnd
EndFunc
#ce

Func _clickTreeItem($hWnd, $idDebug, $strLevel1, $strLevel2 = False)
	$strControlID = 'SysTreeView321'
	ControlFocus($hWnd, '', $strControlID)
;	Sleep(1000)
	ControlTreeView($hWnd, '', $strControlID, 'Select', $strLevel1)
	Sleep(1000)
;	_TreeViewSelect($hWnd, $idDebug, $strControlID, $strLevel1)
	If $strLevel2 <> False	Then
		ControlTreeView($hWnd, '', $strControlID, 'Expand', $strLevel1)
		Sleep(1000)
		ControlTreeView($hWnd, '', $strControlID, 'Select', $strLevel1 & '|' & $strLevel2)
		Sleep(1000)
;		_TreeViewSelect($hWnd, $idDebug, $strControlID, $strLevel1 & '|' & $strLevel2)
	EndIf

	$hCtrl = ControlGetHandle($hWnd, '', $strControlID)
	$hItem = _GUICtrlTreeView_GetSelection($hCtrl)	;Get currently selected TreeView item
	_GUICtrlTreeView_ClickItem($hCtrl, $hItem)				;perform a single click
;	Sleep(1000)
	_closeNewDlg($idDebug)
EndFunc

#cs
Func _yinheAddShenzhenOrderEntry($hWnd, $idDebug, $strControlID, $strAccount, $strSymbol, $strAmount)
	If _CtlSendString($hWnd, $idDebug, 'Edit1', $strSymbol) Then _addSymbolSpecialKey($idDebug, $strSymbol)
	ControlCommand($hWnd, '', $strControlID, 'SelectString', $strAccount)

	$strCash = _CtlGetText($hWnd, $idDebug, 'Static6')
	If Number($strCash, 3) < Number($strAmount, 3) Then
		_CtlDebug($idDebug, $strSymbol & '申购资金不足')
		Return False
	EndIf

	_CtlSetText($hWnd, $idDebug, 'Edit2', $strAmount)
	ControlClick($hWnd, '', 'Button1')
	Sleep(1000)
	_DlgClickButton($idDebug, '基金风险揭示', '我已阅读并同意签署')

	$hFileWnd = WinWait('基金概要文件', '本人已认真阅读并确认上述内容', 10)
	If $hFileWnd <> 0 Then
		WinActivate($hFileWnd)
		ControlClick($hFileWnd, '', 'Button11')	;本人已认真阅读并确认上述内容
		Sleep(1000)
		ControlClick($hFileWnd, '', 'Button1')	;确认
		Sleep(1000)
	EndIf

	_DlgClickButton($idDebug, '提示信息', '确认')
	_DlgClickButton($idDebug, '提示', '确认')
	_DlgClickButton($idDebug, '提示', '确认')

	If _isSingleAccountSymbol($strSymbol) Then	Return False
	Return True
EndFunc
#ce

Func _huabaoAddOrderEntry($hWnd, $idDebug, $strControlID, $strAccount, $strSymbol, $strAmount)
	If _CtlSendString($hWnd, $idDebug, 'Edit1', $strSymbol) Then _addSymbolSpecialKey($idDebug, $strSymbol)
	ControlCommand($hWnd, '', $strControlID, 'SelectString', $strAccount)

	$strCash = _CtlGetText($hWnd, $idDebug, 'Static24')
	If Number($strCash, 3) < Number($strAmount, 3) Then
		_CtlDebug($idDebug, $strSymbol & '申购资金不足')
		Return False
	EndIf

	_CtlSetText($hWnd, $idDebug, 'Edit2', $strAmount)
	ControlClick($hWnd, '', 'Button10')
	Sleep(1000)
	_DlgClickButton($idDebug, '请认真阅读产品信息', '本人已阅读并确认了解' & $strSymbol & '基金产品情况及购买风险')
	_DlgClickButton($idDebug, '请认真阅读产品信息', '下一步')
	_DlgClickButton($idDebug, '提示', '确认')
	_DlgClickButton($idDebug, '提示', '确认')

	If _isSingleAccountSymbol($strSymbol) Then	Return False
	Return True
EndFunc

Func _yinheClickFund($hWnd, $idDebug, $strType)
	$str = '基金' & $strType
	_clickTreeItem($hWnd, $idDebug, '场内开放式基金', $str)
	_CtlWaitText($hWnd, $idDebug, 'ComboBox3', $str)
	_CtlWaitText($hWnd, $idDebug, 'Static1', '股东代码:')
	Return 'ComboBox2'
EndFunc

Func _getFundAmount($strSymbol)
	Switch $strSymbol
		Case '160216'
			$strAmount = '10000'
		Case '160416'
			$strAmount = '2000'
		Case '161125'
			$strAmount = '100'
		Case '161126'
			$strAmount = '300'
		Case '161127'
			$strAmount = '300'
		Case '161226'
			$strAmount = '50000'
		Case '162411'
			$strAmount = '100'
		Case '163208'
			$strAmount = '100'
		Case '164824'
			$strAmount = '100'
		Case '164906'
			$strAmount = '5000'
		Case '501225'
			$strAmount = '1000'
	EndSwitch
	return $strAmount
EndFunc

Func YinheOrderFund($hWnd, $idDebug, $strSymbol)
	$strAmount = _getFundAmount($strSymbol)
	_clickTreeItem($hWnd, $idDebug, '场内开放式基金', '多股东基金申购')
	_CtlWaitText($hWnd, $idDebug, 'Static1', '基金代码:')
	If _CtlSendString($hWnd, $idDebug, 'Edit1', $strSymbol) Then _addSymbolSpecialKey($idDebug, $strSymbol)
	$strCash = _CtlGetText($hWnd, $idDebug, 'Static5')

	$strControlID = 'SysListView321'
	$idListView = ControlGetHandle($hWnd, '', $strControlID)
;	$iItemCount = _GUICtrlListView_GetItemCount($idListView)
	$iItemCount = ControlListView($hWnd, '', $strControlID, 'GetItemCount')
	If _isSingleAccountSymbol($strSymbol) Then $iItemCount = 1

#cs
	$iSubitemCount = ControlListView($hWnd, '', $strControlID, 'GetSubItemCount')
	_CtlDebug($idDebug, '总列数：' & String($iSubitemCount))
	For $i = 0 To $iItemCount - 1
		For $j = 0 To $iSubitemCount - 1
			$strText = ControlListView($hWnd, '', $strControlID, 'GetText', $i, $j)
			_CtlDebug($idDebug, String($i) & String($j) & $strText)
		Next
	Next
#ce

	$iTotalAmount = $iItemCount * Number($strAmount)
	If Number($strCash, 3) < $iTotalAmount Then
		_CtlDebug($idDebug, $strSymbol & '申购资金不足' & String($iTotalAmount))
		Return
	EndIf
	_CtlSendString($hWnd, $idDebug, 'Edit2', $strAmount)

	$arWinPos = WinGetPos($idListView)
	For $i = 0 To $iItemCount - 1
		$arRect = _GUICtrlListView_GetSubItemRect($idListView, $i, 0)
;		$text = StringFormat("Subitem Rectangle : [%d, %d, %d, %d]", $arRect[0], $arRect[1], $arRect[2], $arRect[3])
;		$strDebug = $i & $text
;		_CtlDebug($idDebug, $strDebug)
		MouseClick($MOUSE_CLICK_PRIMARY, $arWinPos[0] + $arRect[0] + 10, $arWinPos[1] + $arRect[1] + 10)
	Next

	ControlClick($hWnd, '', 'Button1')
	Sleep(1000)
	_DlgClickButton($idDebug, '基金风险揭示', '我已阅读并同意签署')
	$hFileWnd = WinWait('基金概要文件', '本人已认真阅读并确认上述内容', 10)
	If $hFileWnd <> 0 Then
		WinActivate($hFileWnd)
		ControlClick($hFileWnd, '', 'Button11')	;本人已认真阅读并确认上述内容
		Sleep(1000)
		ControlClick($hFileWnd, '', 'Button1')	;确认
		Sleep(1000)
	EndIf
	_DlgClickButton($idDebug, '提示信息', '确认')
	_DlgClickButton($idDebug, '提示', '确认')
	_DlgClickButton($idDebug, '提示', '确认')

#cs
	$strControlID = _yinheClickFund($hWnd, $idDebug, '申购')
	$iSel = 0
	While 1
		$strAccount = _CtlSelectString($hWnd, $idDebug, $strControlID, $iSel)
		If $strAccount == False Then ExitLoop

		_closeNewDlg($idDebug)
		If _isAccountMatchSymbol($strAccount, $strSymbol) Then
			If _yinheAddShenzhenOrderEntry($hWnd, $idDebug, $strControlID, $strAccount, $strSymbol, $strAmount) == False Then ExitLoop
		EndIf
	WEnd
#ce
EndFunc

Func HuabaoOrderFund($hWnd, $idDebug, $strSymbol)
	$strAmount = _getFundAmount($strSymbol)
	_clickTreeItem($hWnd, $idDebug, '其它业务', '交易所基金申赎')
	_CtlWaitText($hWnd, $idDebug, 'Static31', '选择操作:')
	_CtlWaitText($hWnd, $idDebug, 'ComboBox3', '基金申购')
	_CtlWaitText($hWnd, $idDebug, 'Static19', '股东代码:')
	$strControlID = 'ComboBox2'

	$iSel = 0
	While 1
		$strAccount = _CtlSelectString($hWnd, $idDebug, $strControlID, $iSel)
		If $strAccount == False Then ExitLoop

		_closeNewDlg($idDebug)
		If _isAccountMatchSymbol($strAccount, $strSymbol) Then
			If _huabaoAddOrderEntry($hWnd, $idDebug, $strControlID, $strAccount, $strSymbol, $strAmount) == False Then ExitLoop
		EndIf
	WEnd
EndFunc

Func _sendSellQuantity($hWnd, $idDebug, $iTotal = 0, $strCtlAvailable = 'Static8', $strCtlQuantity = 'Edit5', $strCtlSell = 'Button1')
	$iCount = 0
	While $iCount < 5
		$strQuantity = _CtlGetText($hWnd, $idDebug, $strCtlAvailable)
		If $strQuantity <> '0' Then
			$iSell = Number($strQuantity)
			If $iTotal > 0 And $iTotal < $iSell Then
				$iSell = Int($iTotal / 100)
				$iSell *= 100
				$strQuantity = String($iSell)
			EndIf
			_CtlSetText($hWnd, $idDebug, $strCtlQuantity, $strQuantity)
			ControlClick($hWnd, '', $strCtlSell)
			Sleep(1000)
			Return $iSell
		EndIf
		Sleep(1000)
		$iCount += 1
	WEnd
	_CtlDebug($idDebug, '5秒钟没有读到可用数量，如果实际可用数量不为0，建议更换网络。')
	Return 0
EndFunc

Func _yinheAddShenzhenRedeemEntry($hWnd, $idDebug, $strSymbol, $strSellQuantity, ByRef $iRemainQuantity)
	If _CtlSendString($hWnd, $idDebug, 'Edit1', $strSymbol) Then _addSymbolSpecialKey($idDebug, $strSymbol)

	$iSell = _sendSellQuantity($hWnd, $idDebug, $iRemainQuantity, 'Static9', 'Edit2')
	If $iSell > 0 Then
		_DlgClickButton($idDebug, '提示', '确认')
		_DlgClickButton($idDebug, '提示', '确认')
		If $strSellQuantity <> '' Then
			$iRemainQuantity -= $iSell
			If $iRemainQuantity < 100 Then Return False
		EndIf
	EndIf

	Return True
EndFunc

Func YinheRedeemFund($hWnd, $idDebug, $strSymbol, $strSellQuantity, ByRef $iRemainQuantity)
	$strControlID = _yinheClickFund($hWnd, $idDebug, '赎回')
	$iSel = 0
	While 1
		$strAccount = _CtlSelectString($hWnd, $idDebug, $strControlID, $iSel)
		If $strAccount == False Then ExitLoop

		_closeNewDlg($idDebug)
		If _isAccountMatchSymbol($strAccount, $strSymbol) Then
			_CtlDebug($idDebug, '剩余赎回数量：' & String($iRemainQuantity))
			If _yinheAddShenzhenRedeemEntry($hWnd, $idDebug, $strSymbol, $strSellQuantity, $iRemainQuantity) == False Then	Return False
		EndIf
	WEnd
	Return True
EndFunc

Func _sendSellSymbol($hWnd, $idDebug, $strSymbol)
	If _CtlSendString($hWnd, $idDebug, 'AfxWnd423', $strSymbol) Then _addSymbolSpecialKey($idDebug, $strSymbol)
EndFunc

Func _getSellStaticIndex($iSoftware, $iIndex)
	If ($iSoftware == $YINHE)	Then
	Else
		$iIndex += 18
	EndIf
	return 'Static' & String($iIndex)
EndFunc

Func _getSellButton($iSoftware)
	If ($iSoftware == $YINHE)	Then
		$strCtlSell = 'Button1'
	Else
		$strCtlSell = 'Button10'
	EndIf
	return $strCtlSell
EndFunc

Func _clickTreeSell($hWnd, $iSoftware, $idDebug)
	_clickTreeItem($hWnd, $idDebug, '卖出')
	_CtlWaitText($hWnd, $idDebug, _getSellStaticIndex($iSoftware, 9), '股东代码:')
	_CtlWaitText($hWnd, $idDebug, _getSellStaticIndex($iSoftware, 5), '卖出价格:')
	Return 'ComboBox3'
EndFunc

Func _addSellEntry($hWnd, $iSoftware, $idDebug, $strSymbol, $strPrice, $strSellQuantity, ByRef $iRemainQuantity)
	_sendSellSymbol($hWnd, $idDebug, $strSymbol)
	$strPriceControl = 'Edit2'
	$strSuggestedPrice = _CtlGetText($hWnd, $idDebug, $strPriceControl)
	If $strPrice <> '' Then
		If $strSuggestedPrice <> $strPrice Then	_CtlSetText($hWnd, $idDebug, $strPriceControl, $strPrice)
	EndIf

	$iSell = _sendSellQuantity($hWnd, $idDebug, $iRemainQuantity, _getSellStaticIndex($iSoftware, 8), 'Edit5', _getSellButton($iSoftware))
	If $iSell > 0 Then
		_DlgClickButton($idDebug, '卖出交易确认', '卖出确认')
		_DlgClickButton($idDebug, '提示', '确认')
		If $strSellQuantity <> '' Then
			$iRemainQuantity -= $iSell
			If $iRemainQuantity < 100 Then Return -1
		EndIf
	EndIf

	Return $iSell
EndFunc

Func RunSell($hWnd, $iSoftware, $idDebug, $strSymbol, $strPrice, $strSellQuantity, ByRef $iRemainQuantity)
;	$strHour = StringLeft(_NowTime(4), 2)
;	_CtlDebug($idDebug, '当前小时：' & $strHour)

	$strControlID = _clickTreeSell($hWnd, $iSoftware, $idDebug)
;	While 1
		$iSel = 0
		$iTotal = 0
		While 1
			$strAccount = _CtlSelectString($hWnd, $idDebug, $strControlID, $iSel)
			If $strAccount == False Then ExitLoop

			_closeNewDlg($idDebug)
			If _isAccountMatchSymbol($strAccount, $strSymbol) Then
				_CtlDebug($idDebug, '剩余卖出数量：' & String($iRemainQuantity))
				$iSold = _addSellEntry($hWnd, $iSoftware, $idDebug, $strSymbol, $strPrice, $strSellQuantity, $iRemainQuantity)
				$iTotal += $iSold
				If $iSold == -1 Then
					Return False
				ElseIf $iSold == 0 Then
;					If Number($strHour) < 16 Then Return True	; 交易时间段不反复检查是否下单成功
					Return True
				EndIf
			EndIf
		WEnd
		_CtlDebug($idDebug, '下单数量：' & String($iTotal))
;		If $iTotal == 0 Or Number($strHour) < 16 Then ExitLoop
;	WEnd
	Return True
EndFunc

Func _addMoneyMangeEntry($hWnd, $iSoftware, $idDebug)
;	_sendSellSymbol($hWnd, $idDebug, '131810')
	_sendSellSymbol($hWnd, $idDebug, '204001')
	$strPriceControl = 'Edit2'
	$strSuggestedPrice = _CtlGetText($hWnd, $idDebug, $strPriceControl)
	$fPrice = Number($strSuggestedPrice, 3)
	$fPrice -= 0.1
	_CtlSetText($hWnd, $idDebug, $strPriceControl, String($fPrice))

	If _sendSellQuantity($hWnd, $idDebug, 0, _getSellStaticIndex($iSoftware, 8), 'Edit5', _getSellButton($iSoftware)) Then
		_DlgClickButton($idDebug, '融券交易确认', '融券确认')
		_DlgClickButton($idDebug, '提示', '确认')
	EndIf
EndFunc

Func RunMoneyManage($hWnd, $iSoftware, $idDebug)
	$strControlID = _clickTreeSell($hWnd, $iSoftware, $idDebug)
	$iSel = 0
	While 1
		$strAccount = _CtlSelectString($hWnd, $idDebug, $strControlID, $iSel)
		If $strAccount == False Then ExitLoop

		_closeNewDlg($idDebug)
		If _isShanghaiAccount($strAccount) Then
;			If _isShanghaiFundAccount($strAccount) == False	Then
				_addMoneyMangeEntry($hWnd, $iSoftware, $idDebug)
				ExitLoop
;			EndIf
		EndIf
	WEnd
EndFunc

Func RunCancelAll($hWnd, $idDebug, $strSymbol)
	_clickTreeItem($hWnd, $idDebug, '撤单')
	_CtlWaitText($hWnd, $idDebug, 'Static18', '证券代码:')
	$strSelectAll = '全选中'
	_CtlWaitText($hWnd, $idDebug, 'Button4', $strSelectAll)
	_CtlSendString($hWnd, $idDebug, 'Edit5', $strSymbol)
	Sleep(2000)

	$idListView = ControlGetHandle($hWnd, '', 'SysListView321')
	$strDebug = String($idListView)
	$strDebug &= ' ' & _GUICtrlListView_GetItemTextString($idListView, 0)
	_CtlDebug($idDebug, $strDebug & _GUICtrlListView_GetItemText($idListView, 0))

	$strCount = _CtlGetText($hWnd, $idDebug, 'Static12')
	If $strCount <> '共0条' And $strCount <> 'qQ0' Then
		_CtlClickButton($hWnd, $idDebug, $strSelectAll)
		_CtlClickButton($hWnd, $idDebug, '撤 单')
		_DlgClickButton($idDebug, '提示', '确认')
		Sleep(3000)
		_DlgClickButton($idDebug, '提示', '确认')
	EndIf
EndFunc

Func RunCashBack($hWnd, $idDebug, $strPassword)
	_clickTreeItem($hWnd, $idDebug, '资金划转', '银证转账')
	_CtlWaitText($hWnd, $idDebug, 'Static2', '选择银行:')
	_CtlWaitText($hWnd, $idDebug, 'Static9', '转账方式:')
	ControlCommand($hWnd, '', 'ComboBox2', 'SetCurrentSelection', 1)
	$iCount = 0
	Do
		Sleep(100)
		$iCount += 1
		If $iCount > 50	Then
			_CtlDebug($idDebug, '5秒钟没有读到最大可转，如果实际可转金额不为0，建议更换网络。')
			Return
		EndIf
		$strCash = ControlGetText($hWnd, '', 'Static13')
	Until $strCash <> ''
	If Number($strCash, 3) > 0.009 Then
		_CtlSendPassword($hWnd, $idDebug, 'AfxWnd424', $strPassword)
		_CtlSetText($hWnd, $idDebug, 'Edit1', $strCash)
		ControlClick($hWnd, '', 'Button1')
		Sleep(1000)
		_DlgClickButton($idDebug, '确认提示', '确认')
		_DlgClickButton($idDebug, '提示', '确认')
	EndIf
EndFunc

Func _debugProgress($idProgress, $iMax, $iCur)
	GUICtrlSetData($idProgress, Number(100 * ($iCur + 1) / $iMax))
EndFunc

Func _addOtherAccount($hWnd, $iSoftware, $idDebug, $strAccount, $strPassword)
	WinActivate($hWnd)
    $arWinPos = WinGetPos($hWnd)
	$arPos = ControlGetPos($hWnd, '', 'ComboBox1')
	MouseClick($MOUSE_CLICK_PRIMARY, $arWinPos[0] + $arPos[0] - 10, $arWinPos[1] + $arPos[1] + 38)
	Sleep(1000)
	Send('{DOWN}')
	Sleep(1000)
	Send('{ENTER}')
	Sleep(1000)
	_closeNewDlg($idDebug)
	_loginDlg($iSoftware, $idDebug, '添加帐号', $strAccount, $strPassword)
EndFunc

Func RunLoginOnly($hWnd, $idProgress, $iSoftware, $idDebug, Const ByRef $arAccountNumber, Const ByRef $arAccountPassword, Const ByRef $arAccountChecked, $iMax, $iCur)
	For $i = $iCur + 1 to $iMax - 1
		_debugProgress($idProgress, $iMax, $i)
		If $arAccountChecked[$i] == $GUI_CHECKED Then _addOtherAccount($hWnd, $iSoftware, $idDebug, $arAccountNumber[$i], $arAccountPassword[$i])
	Next

	If ($iSoftware == $YINHE)	Then
		_clickTreeItem($hWnd, $idDebug, '查询', '当日委托')
		_CtlWaitText($hWnd, $idDebug, 'Button16', '按股票代码汇总')
		$strControl = 'Button17'
		_CtlWaitText($hWnd, $idDebug, $strControl, '按买卖方向汇总')
		ControlClick($hWnd, '', $strControl)
	Else
		_clickTreeItem($hWnd, $idDebug, '查询', '资金股份')
	EndIf
EndFunc

Func _hotKeyPressed()
    Switch @HotKeyPressed ; The last hotkey pressed.
        Case '{ESC}' ; String is the {ESC} hotkey.
            Exit
    EndSwitch
EndFunc

const $strRegKey = 'HKEY_CURRENT_USER\Software\AutoIt_yinhe'

Func _getProfileString($strValName, $strDefault = '', $strKeyName = $strRegKey)
	$strVal = RegRead($strKeyName, $strValName)
	If @error Or @extended <> $REG_SZ Then Return $strDefault
	Return $strVal
EndFunc

Func _putProfileString($strValName, $strVal, $strKeyName = $strRegKey)
	RegWrite($strKeyName, $strValName, 'REG_SZ', $strVal)
EndFunc

Func _getProfileInt($strValName, $iDefault = 0, $strKeyName = $strRegKey)
	$iVal = RegRead($strKeyName, $strValName)
	If @error Or @extended <> $REG_DWORD Then Return $iDefault
	Return $iVal
EndFunc

Func _putProfileInt($strValName, $iVal, $strKeyName = $strRegKey)
	RegWrite($strKeyName, $strValName, 'REG_DWORD', $iVal)
EndFunc

Func _getRadioState($idRadio, ByRef $iMsg, $strValName, $iDefault)
	$iState = _getProfileInt($strValName, $iDefault)
	If $iState == $GUI_CHECKED Then $iMsg = $idRadio
	Return $iState
EndFunc

Func _toggleAccounts(Const ByRef $arCheckbox, $iMax)
	If $GUI_UNCHECKED == GUICtrlRead($arCheckbox[0], $GUI_READ_EXTENDED) Then
		$iState = $GUI_CHECKED
	Else
		$iState = $GUI_UNCHECKED
	EndIf

	For $i = 0 to $iMax - 1
		GUICtrlSetState($arCheckbox[$i], $iState)
	Next
EndFunc

Func _getSoftwarePrefix($iSoftware)
	If ($iSoftware == $YINHE)	Then
		$strPrefix = ''
	Else
		$strPrefix = 'h'
	EndIf
	return $strPrefix
EndFunc

Func RunOperation($iSoftware, $idProgress, $idDebug)
	GUICtrlSetState($idProgress, $GUI_ENABLE)

	$strPrefix = _getSoftwarePrefix($iSoftware)
	$iMax = _getProfileInt($strPrefix & 'AccountTotal')
	Local $arAccountNumber[$iMax]
	Local $arAccountPassword[$iMax]
	Local $arAccountChecked[$iMax]

	For $i = 0 to $iMax - 1
		$strIndex = String($i)
		$arAccountNumber[$i] = _getProfileString($strPrefix & 'AccountNumber' & $strIndex)
		$arAccountPassword[$i] = _getProfileString($strPrefix & 'AccountPassword' & $strIndex)
		$arAccountChecked[$i] = _getProfileInt($strPrefix & 'AccountState' & $strIndex)
	Next

	$strSymbol = _getProfileString('Symbol')
	$strSellQuantity = _getProfileString('SellQuantity')
	$iRemainQuantity = Number($strSellQuantity) + 50
	For $i = 0 to $iMax - 1
		_debugProgress($idProgress, $iMax, $i)
		If $arAccountChecked[$i] == $GUI_CHECKED Then
			_GUICtrlListBox_ResetContent($idDebug)
			$strPassword = $arAccountPassword[$i]
			$hWnd = AppOpen($iSoftware, $idDebug, $arAccountNumber[$i], $strPassword)
			If _getProfileInt('Order') == $GUI_CHECKED Then
				If ($iSoftware == $YINHE)	Then
					YinheOrderFund($hWnd, $idDebug, $strSymbol)
				Else
					HuabaoOrderFund($hWnd, $idDebug, $strSymbol)
				EndIf
			ElseIf _getProfileInt('Redeem') == $GUI_CHECKED Then
				If YinheRedeemFund($hWnd, $idDebug, $strSymbol, $strSellQuantity, $iRemainQuantity) == False Then
					AppClose($hWnd, $idDebug)
					ExitLoop
				EndIf
			ElseIf _getProfileInt('Sell') == $GUI_CHECKED Then
				If RunSell($hWnd, $iSoftware, $idDebug, $strSymbol, _getProfileString('SellPrice'), $strSellQuantity, $iRemainQuantity) == False Then
					AppClose($hWnd, $idDebug)
					ExitLoop
				EndIf
			ElseIf _getProfileInt('Money') == $GUI_CHECKED Then
				RunMoneyManage($hWnd, $iSoftware, $idDebug)
			ElseIf _getProfileInt('Cash') == $GUI_CHECKED Then
				RunCashBack($hWnd, $idDebug, $strPassword)
			ElseIf _getProfileInt('Cancel') == $GUI_CHECKED Then
				RunCancelAll($hWnd, $idDebug, $strSymbol)
			ElseIf _getProfileInt('Login') == $GUI_CHECKED Then
				RunLoginOnly($hWnd, $idProgress, $iSoftware, $idDebug, $arAccountNumber, $arAccountPassword, $arAccountChecked, $iMax, $i)
				ExitLoop
			EndIf
			AppClose($hWnd, $idDebug)
		EndIf
	Next

	If $strSellQuantity <> '' Then
		$iQuantity = Number($strSellQuantity) - $iRemainQuantity + 50
		If $iQuantity <> 0 Then _CtlDebug($idDebug, '实际下单：' & String($iQuantity))
	EndIf

	GUICtrlSetData($idProgress, 0)
	GUICtrlSetState($idProgress, $GUI_DISABLE)
EndFunc

Func _getSelectedPassword($iSoftware, $idSelectedItem, Const ByRef $arCheckboxAccount, $iMax)
	Return _getProfileString(_getSoftwarePrefix($iSoftware) & 'AccountPassword' & String(_getSelectedListViewIndex($idSelectedItem, $arCheckboxAccount, $iMax)))
EndFunc

Func _getSelectedListViewIndex($idSelectedItem, Const ByRef $arCheckboxAccount, $iMax)
	For $i = 0 to $iMax - 1
		If $idSelectedItem == $arCheckboxAccount[$i] Then ExitLoop
	Next
	Return $i
EndFunc

Func _onNewAccount($iSoftware, $idDebug, ByRef $iMax, $strDlgAccount, $strDlgPassword)
	$strIndex = String($iMax)
	$iMax += 1
	$strPrefix = _getSoftwarePrefix($iSoftware)
	_putProfileInt($strPrefix & 'AccountTotal', $iMax)
	_CtlDebug($idDebug, '新账号： ' & $strDlgAccount)
	_putProfileString($strPrefix & 'AccountNumber' & $strIndex, $strDlgAccount)
	_putProfileString($strPrefix & 'AccountPassword' & $strIndex, $strDlgPassword)
EndFunc

Func _onEditAccount($iSoftware, $idDebug, $iIndex, $strDlgAccount, $strDlgPassword)
	$strPrefix = _getSoftwarePrefix($iSoftware)
	$strPasswordName = $strPrefix & 'AccountPassword' & String($iIndex)
	If $strDlgPassword <> _getProfileString($strPasswordName) Then
		_CtlDebug($idDebug, '密码更改')
		_putProfileString($strPasswordName, $strDlgPassword)
	EndIf

	$strAccountName = $strPrefix & 'AccountNumber' & String($iIndex)
	If $strDlgAccount <> _getProfileString($strAccountName) Then
		_CtlDebug($idDebug, '账号更改： ' & $strDlgAccount)
		_putProfileString($strAccountName, $strDlgAccount)
		Return True
	EndIf
	Return False
EndFunc

Func _onMenuCopy($idDebug)
	$arSel = _GUICtrlListBox_GetSelItems($idDebug)
	If $arSel[0] == 0 Then _GUICtrlListBox_SetSel($idDebug)

	$arText = _GUICtrlListBox_GetSelItemsText($idDebug)
	$str = ''
	For $i = 1 To $arText[0]
		$str &= $arText[$i] & @CRLF
	Next
	ClipPut($str)
EndFunc

Func _onMenuDel()
	If MsgBox($MB_ICONQUESTION + $MB_YESNO, '无法恢复的操作', '确定清除全部客户号记录并且退出？') == $IDYES Then
		RegDelete($strRegKey)
		Exit
	EndIf
EndFunc

Func _onRadioSoftware(ByRef $iSoftware, $RadioYinhe, $RadioHuabao)
	If ($iSoftware == $RadioYinhe)	Then
		$iSoftware = $YINHE
	ElseIf ($iSoftware == $RadioHuabao)	Then
		$iSoftware = $HUABAO
	EndIf

	$strPrefix = _getSoftwarePrefix($iSoftware)
	$iMax = _getProfileInt($strPrefix & 'AccountTotal')
	If $iMax == 0 Then
		$iMax = UBound($arPassword)		; get array size
		_putProfileInt($strPrefix & 'AccountTotal', $iMax)

		For $i = 0 to $iMax - 1
			$strIndex = String($i)
			_putProfileString($strPrefix & 'AccountNumber' & $strIndex, $arAccount[$i])
			_putProfileString($strPrefix & 'AccountPassword' & $strIndex, $arPassword[$i])
		Next
	EndIf
	Return $iMax
EndFunc

Func _disableRadios($RadioCash, $RadioCancel, $RadioRedeem)
	$iState = BitOR($GUI_DISABLE, $GUI_UNCHECKED)
	GUICtrlSetState($RadioCash, $iState)
	GUICtrlSetState($RadioCancel, $iState)
	GUICtrlSetState($RadioRedeem, $iState)
EndFunc

Func _loadListViewAccount($iSoftware, $idListViewAccount, ByRef $arCheckboxAccount, $iMax)
	$strPrefix = _getSoftwarePrefix($iSoftware)
	For $i = 0 to $iMax - 1
		$strIndex = String($i)
		$arCheckboxAccount[$i] = GUICtrlCreateListViewItem(_getProfileString($strPrefix & 'AccountNumber' & $strIndex), $idListViewAccount)
		GUICtrlSetState(-1, _getProfileInt($strPrefix & 'AccountState' & $strIndex, $GUI_CHECKED))
	Next
EndFunc

Func AppMain()
	$idFormMain = GUICreate("通达信单独委托版全自动拖拉机0.71", 803, 506, 289, 0)

	$idListViewAccount = GUICtrlCreateListView("客户号", 24, 24, 146, 454, BitOR($GUI_SS_DEFAULT_LISTVIEW,$WS_VSCROLL), BitOR($WS_EX_CLIENTEDGE,$LVS_EX_CHECKBOXES))
	GUICtrlSendMsg(-1, $LVM_SETCOLUMNWIDTH, 0, 118)

	$idMenuAccount = GUICtrlCreateContextMenu($idListViewAccount)
	$idMenuEdit = GUICtrlCreateMenuItem('添加或者修改选中客户号', $idMenuAccount)
	$idMenuDel = GUICtrlCreateMenuItem('清除全部客户号记录', $idMenuAccount)

	$idLabelSymbol = GUICtrlCreateLabel("基金代码", 192, 24, 52, 17)
	$idListSymbol = GUICtrlCreateList("", 192, 48, 121, 97)
	GUICtrlSetData(-1, '160216|160416|160717|161125|161126|161127|161226|162411|163208|164824|164906|501225|510300', _getProfileString('Symbol', '164824'))

	$idLabelSellPrice = GUICtrlCreateLabel("卖出价格", 192, 160, 52, 17)
	$idInputSellPrice = GUICtrlCreateInput("", 192, 184, 121, 21)
	GUICtrlSetData(-1, _getProfileString('SellPrice'))

	$idLabelSellQuantity = GUICtrlCreateLabel("卖出或者赎回总数量", 192, 224, 112, 17)
	$idInputSellQuantity = GUICtrlCreateInput("", 192, 248, 121, 21)
	GUICtrlSetData(-1, _getProfileString('SellQuantity'))

	$idProgressDebug = GUICtrlCreateProgress(336, 24, 438, 17)
	GUICtrlSetState(-1, $GUI_DISABLE)
	$idListDebug = GUICtrlCreateList("", 336, 48, 441, 344, BitOR($LBS_NOTIFY,$LBS_MULTIPLESEL,$WS_VSCROLL,$WS_BORDER))

	$idMenuDebug = GUICtrlCreateContextMenu($idListDebug)
	$idMenuCopy = GUICtrlCreateMenuItem('复制到剪贴板', $idMenuDebug)

	$GroupSoftware = GUICtrlCreateGroup("软件", 336, 400, 225, 81)
	$iSoftware = 0
	$RadioYinhe = GUICtrlCreateRadio("银河证券海王星单独委托版3.13", 352, 424, 193, 17)
	GUICtrlSetState(-1, _getRadioState($RadioYinhe, $iSoftware, 'Yinhe', $GUI_CHECKED))
	$RadioHuabao = GUICtrlCreateRadio("华宝证券通达信版独立交易8.17", 352, 448, 193, 17)
	GUICtrlSetState(-1, _getRadioState($RadioHuabao, $iSoftware, 'Huabao', $GUI_UNCHECKED))
	GUICtrlCreateGroup("", -99, -99, 1, 1)
	$iMax = _onRadioSoftware($iSoftware, $RadioYinhe, $RadioHuabao)
	Local $arCheckboxAccount[$iMax]
	_loadListViewAccount($iSoftware, $idListViewAccount, $arCheckboxAccount, $iMax)

	$GroupOperation = GUICtrlCreateGroup("操作", 192, 288, 121, 193)
	$iMsg = 0
	$RadioCash = GUICtrlCreateRadio("转账回银行", 208, 312, 89, 17)
	$RadioMoney = GUICtrlCreateRadio("逆回购", 208, 336, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioMoney, $iMsg, 'Money', $GUI_UNCHECKED))
	$RadioOrder = GUICtrlCreateRadio("场内申购", 208, 360, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioOrder, $iMsg, 'Order', $GUI_CHECKED))
	$RadioRedeem = GUICtrlCreateRadio("赎回", 208, 384, 89, 17)
	$RadioSell = GUICtrlCreateRadio("卖出", 208, 408, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioSell, $iMsg, 'Sell', $GUI_UNCHECKED))
	$RadioCancel = GUICtrlCreateRadio("全部撤单", 208, 432, 89, 17)
	$RadioLogin = GUICtrlCreateRadio("仅登录查询", 208, 456, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioLogin, $iMsg, 'Login', $GUI_UNCHECKED))
	If ($iSoftware == $YINHE)	Then
		GUICtrlSetState($RadioCash, _getRadioState($RadioCash, $iMsg, 'Cash', $GUI_UNCHECKED))
		GUICtrlSetState($RadioCancel, _getRadioState($RadioCancel, $iMsg, 'Cancel', $GUI_UNCHECKED))
		GUICtrlSetState($RadioRedeem, _getRadioState($RadioRedeem, $iMsg, 'Redeem', $GUI_UNCHECKED))
	Else
		_disableRadios($RadioCash, $RadioCancel, $RadioRedeem)
	EndIf
	GUICtrlCreateGroup("", -99, -99, 1, 1)

	$idButtonRun = GUICtrlCreateButton("执行自动操作(&R)", 672, 456, 107, 25)
	GUICtrlSetState(-1, $GUI_FOCUS)
	GUISetState(@SW_SHOW)

	HotKeySet('{ESC}', '_hotKeyPressed')
	_CtlDebug($idListDebug, '按ESC键随时退出脚本程序')

	$idDlgAccount = -1
	$idButtonCancel = -1
	$idButtonOk = -2
	While 1
		Switch $iMsg
			Case $RadioCash, $RadioMoney, $RadioLogin
				If GUICtrlRead($iMsg) == $GUI_CHECKED Then
					GUICtrlSetState($idInputSellPrice, $GUI_DISABLE)
					GUICtrlSetState($idInputSellQuantity, $GUI_DISABLE)
					GUICtrlSetState($idListSymbol, $GUI_DISABLE)
				EndIf

			Case $RadioOrder, $RadioCancel
				If GUICtrlRead($iMsg) == $GUI_CHECKED Then
					GUICtrlSetState($idInputSellPrice, $GUI_DISABLE)
					GUICtrlSetState($idInputSellQuantity, $GUI_DISABLE)
					GUICtrlSetState($idListSymbol, $GUI_ENABLE)
				EndIf

			Case $RadioRedeem
				If GUICtrlRead($iMsg) == $GUI_CHECKED Then
					GUICtrlSetState($idInputSellPrice, $GUI_DISABLE)
					GUICtrlSetState($idInputSellQuantity, $GUI_ENABLE)
					GUICtrlSetState($idListSymbol, $GUI_ENABLE)
				EndIf

			Case $RadioSell
				If GUICtrlRead($iMsg) == $GUI_CHECKED Then
					GUICtrlSetState($idInputSellPrice, $GUI_ENABLE)
					GUICtrlSetState($idInputSellQuantity, $GUI_ENABLE)
					GUICtrlSetState($idListSymbol, $GUI_ENABLE)
				EndIf

			Case $RadioYinhe, $RadioHuabao
				$iSoftware = $iMsg
				$iMax = _onRadioSoftware($iSoftware, $RadioYinhe, $RadioHuabao)
				_GUICtrlListView_DeleteAllItems($idListViewAccount)
				If ($iMax <> 0)	Then
					ReDim $arCheckboxAccount[$iMax]
					_loadListViewAccount($iSoftware, $idListViewAccount, $arCheckboxAccount, $iMax)
				EndIf
				If ($iSoftware == $YINHE)	Then
					GUICtrlSetState($RadioCancel, $GUI_ENABLE)
					GUICtrlSetState($RadioCash, $GUI_ENABLE)
					GUICtrlSetState($RadioRedeem, $GUI_ENABLE)
				Else
					_disableRadios($RadioCash, $RadioCancel, $RadioRedeem)
				EndIf

			Case $idListViewAccount
				_toggleAccounts($arCheckboxAccount, $iMax)

			Case $idButtonRun
				$strPrefix = _getSoftwarePrefix($iSoftware)
				For $i = 0 to $iMax - 1
					_putProfileInt($strPrefix & 'AccountState' & String($i), GUICtrlRead($arCheckboxAccount[$i], $GUI_READ_EXTENDED))
				Next
				_putProfileString('Symbol', GUICtrlRead($idListSymbol))
				_putProfileInt('Cash', GUICtrlRead($RadioCash))
				_putProfileInt('Money', GUICtrlRead($RadioMoney))
				_putProfileInt('Order', GUICtrlRead($RadioOrder))
				_putProfileInt('Redeem', GUICtrlRead($RadioRedeem))
				_putProfileInt('Sell', GUICtrlRead($RadioSell))
				_putProfileInt('Cancel', GUICtrlRead($RadioCancel))
				_putProfileInt('Login', GUICtrlRead($RadioLogin))
				_putProfileInt('Yinhe', GUICtrlRead($RadioYinhe))
				_putProfileInt('Huabao', GUICtrlRead($RadioHuabao))
				_putProfileString('SellPrice', GUICtrlRead($idInputSellPrice))
				_putProfileString('SellQuantity', GUICtrlRead($idInputSellQuantity))
				GUICtrlSetState($idButtonRun, $GUI_DISABLE)
				GUICtrlSetState($idListViewAccount, $GUI_DISABLE)
				GUICtrlSetState($idListDebug, $GUI_DISABLE)
				RunOperation($iSoftware, $idProgressDebug, $idListDebug)
				GUICtrlSetState($idButtonRun, $GUI_ENABLE)
				GUICtrlSetState($idListViewAccount, $GUI_ENABLE)
				GUICtrlSetState($idListDebug, $GUI_ENABLE)

			Case $idMenuCopy
				_onMenuCopy($idListDebug)

			Case $idMenuDel
				_onMenuDel()

			Case $idMenuEdit
				$idSelectedItem = GUICtrlRead($idListViewAccount)
				If $idSelectedItem == 0 Then
					$strDlgCaption = '新建'
					$strDlgAccount = $arAccount[0]
					$strDlgPassword = $arPassword[0]
				Else
					$strDlgCaption = '修改'
					$strDlgAccount = StringTrimRight(GUICtrlRead($idSelectedItem), 1)
					$strDlgPassword = _getSelectedPassword($iSoftware, $idSelectedItem, $arCheckboxAccount, $iMax)
				EndIf
				$idDlgAccount = GUICreate($strDlgCaption, 284, 199, -1, -1, $GUI_SS_DEFAULT_GUI, -1, $idFormMain)
				$idLabelAccount = GUICtrlCreateLabel('客户号', 24, 24, 40, 17)
				$idInputAccount = GUICtrlCreateInput($strDlgAccount, 24, 48, 233, 21, BitOR($GUI_SS_DEFAULT_INPUT,$ES_NUMBER))
				$idLabelPassword = GUICtrlCreateLabel('密码', 24, 96, 28, 17, 0)
				$idEditPassword = GUICtrlCreateInput($strDlgPassword, 24, 112, 233, 21, BitOR($GUI_SS_DEFAULT_INPUT,$ES_PASSWORD))
				$idButtonCancel = GUICtrlCreateButton('取消(&C)', 88, 152, 75, 25, $BS_NOTIFY)
				$idButtonOk = GUICtrlCreateButton('确定(&O)', 184, 152, 75, 25, $BS_NOTIFY)
				GUISetState(@SW_SHOW)
				GUISwitch($idFormMain)
				GUISetState(@SW_DISABLE)

			Case $GUI_EVENT_CLOSE, $idButtonCancel, $idButtonOk
				If $idDlgAccount == -1 Then
					Exit
				Else
					GUISwitch($idFormMain)
					If $iMsg == $idButtonOk Then
						$strDlgAccount = GUICtrlRead($idInputAccount)
						$strDlgPassword = GUICtrlRead($idEditPassword)
						If $strDlgAccount <> '' And $strDlgPassword <> '' Then
							If $idSelectedItem == 0 Then
								_onNewAccount($iSoftware, $idListDebug, $iMax, $strDlgAccount, $strDlgPassword)
								ReDim $arCheckboxAccount[$iMax]
								$arCheckboxAccount[$iMax - 1] = GUICtrlCreateListViewItem($strDlgAccount, $idListViewAccount)
								GUICtrlSetState(-1, $GUI_CHECKED)
							Else
								$iIndex = _getSelectedListViewIndex($idSelectedItem, $arCheckboxAccount, $iMax)
								If _onEditAccount($iSoftware, $idListDebug, $iIndex, $strDlgAccount, $strDlgPassword) Then
									_GUICtrlListView_DeleteAllItems($idListViewAccount)
									_loadListViewAccount($iSoftware, $idListViewAccount, $arCheckboxAccount, $iMax)
								EndIf
							EndIf
						EndIf
					EndIf

					GUISetState(@SW_ENABLE)
					GUIDelete($idDlgAccount)
					$idDlgAccount = -1
					$idButtonCancel = -1
					$idButtonOk = -2
				EndIf
		EndSwitch
		$iMsg = GUIGetMsg()
	WEnd

	GUIDelete($idFormMain)
EndFunc

	AppMain()
