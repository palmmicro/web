#cs
	Title:   		拖拉机自动化
	Filename:  		yinhe.au3
	Description: 	拖拉机账户自动申购、卖出、撤单、逆回购和银证转账回银行。
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

#include <GuiTreeView.au3>
#include <GuiListView.au3>

#include <Date.au3>

#include <yinheaccounts.au3>
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

Func _MsgDebug($str)
	MsgBox($MB_ICONINFORMATION, '自动化操作暂停中', $str)
EndFunc

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
	_CtlDebug($idDebug, '选择"' & $str & '"')
	Return $str
EndFunc

Func _CtlClickButton($hWnd, $idDebug, $strButton)
	_CtlDebug($idDebug, '模拟点击按钮"' & $strButton & '"')
	WinActivate($hWnd)
	ControlClick($hWnd, '', '[CLASS:Button; TEXT:' & $strButton & ']')
	Sleep(1000)
EndFunc

Func _yinheCloseMsgDlg($idDebug)
	$strButton = '今日不再提示'
	$hMsgWnd = WinGetHandle('消息标题', $strButton)
	If $hMsgWnd <> 0 Then
		If ControlCommand($hMsgWnd, '', 'Button4', 'IsChecked') == 0 Then _CtlClickButton($hMsgWnd, $idDebug, $strButton)
		_CtlClickButton($hMsgWnd, $idDebug, '关闭')
	EndIf
EndFunc

Func _yinheCloseNewDlg($idDebug)
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
		_yinheCloseNewDlg($idDebug)
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
		_yinheCloseNewDlg($idDebug)
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

Func _yinheLoginDlg($idDebug, $strTitle, $strAccount, $strPassword)
	_CtlDebug($idDebug, '等待"' & $strTitle & '"成为活跃窗口')
;	$hWnd = WinWaitActive($strTitle, '验证码')
	$hWnd = WinWaitActive($strTitle, '默认PIN码')

	If StringLeft($strAccount, 1) == '0' Then $strAccount = StringTrimLeft($strAccount, 1)
	_CtlSetText($hWnd, $idDebug, 'Edit1', $strAccount)
	If ControlCommand($hWnd, '', 'Button11', 'IsChecked') == 0 Then _CtlClickButton($hWnd, $idDebug, 'Button11')	;默认PIN码
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
		_yinheCloseNewDlg($idDebug)
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
		_yinheCloseNewDlg($idDebug)
	WEnd
	Sleep(1000)
	_yinheCloseMsgDlg($idDebug)
	Return $hMainWnd
EndFunc

Func YinheLogin($idDebug, $strAccount, $strPassword)
	Run('C:\中国银河证券海王星独立交易\Tc.exe', 'C:\中国银河证券海王星独立交易\')
	Return _yinheLoginDlg($idDebug, '通达信网上交易', $strAccount, $strPassword)
EndFunc

Func YinheClose($hWnd, $idDebug)
	Sleep(1000)
	WinClose($hWnd)
	_DlgClickButton($idDebug, '退出确认', '退出系统')
EndFunc

Func _addSymbolSpecialKey($idDebug, $strSymbol)
	If $strSymbol == '160216' Or $strSymbol == '160416' Or $strSymbol == '161127' Or $strSymbol == '161226' Or $strSymbol == '163208' Or $strSymbol == '164906' Then
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

Func _yinheClickItem($hWnd, $idDebug, $strLevel1, $strLevel2 = False)
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
	_yinheCloseNewDlg($idDebug)
EndFunc

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

	If $strSymbol == '161226' Then	Return False
	Return True
EndFunc

Func _yinheClickFund($hWnd, $idDebug, $strType)
	$str = '基金' & $strType
	_yinheClickItem($hWnd, $idDebug, '场内开放式基金', $str)
	_CtlWaitText($hWnd, $idDebug, 'ComboBox3', $str)
	_CtlWaitText($hWnd, $idDebug, 'Static1', '股东代码:')
	Return 'ComboBox2'
EndFunc

Func YinheOrderFund($hWnd, $idDebug, $strSymbol)
	Switch $strSymbol
		Case '160216'
			$strAmount = '10000'
		Case '160416'
			$strAmount = '2000'
		Case '161127'
			$strAmount = '300'
		Case '161226'
			$strAmount = '50000'
		Case '162411'
			$strAmount = '100'
		Case '163208'
			$strAmount = '100'
		Case '164906'
			$strAmount = '5000'
	EndSwitch

	$strControlID = _yinheClickFund($hWnd, $idDebug, '申购')
	$iSel = 0
	While 1
		$strAccount = _CtlSelectString($hWnd, $idDebug, $strControlID, $iSel)
		If $strAccount == False Then ExitLoop

		_yinheCloseNewDlg($idDebug)
		If _isShenzhenAccount($strAccount) Then
			If _yinheAddShenzhenOrderEntry($hWnd, $idDebug, $strControlID, $strAccount, $strSymbol, $strAmount) == False Then ExitLoop
		EndIf
	WEnd
EndFunc

Func _yinheSendSellQuantity($hWnd, $idDebug, $iTotal = 0, $strCtlAvailable = 'Static8', $strCtlQuantity = 'Edit5')
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
			ControlClick($hWnd, '', 'Button1')
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

	$iSell = _yinheSendSellQuantity($hWnd, $idDebug, $iRemainQuantity, 'Static9', 'Edit2')
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

		_yinheCloseNewDlg($idDebug)
		If _isShenzhenAccount($strAccount) Then
			_CtlDebug($idDebug, '剩余赎回数量：' & String($iRemainQuantity))
			If _yinheAddShenzhenRedeemEntry($hWnd, $idDebug, $strSymbol, $strSellQuantity, $iRemainQuantity) == False Then	Return False
		EndIf
	WEnd
	Return True
EndFunc

Func _yinheSendSellSymbol($hWnd, $idDebug, $strSymbol)
	If _CtlSendString($hWnd, $idDebug, 'AfxWnd423', $strSymbol) Then _addSymbolSpecialKey($idDebug, $strSymbol)
EndFunc

Func _yinheAddShenzhenSellEntry($hWnd, $idDebug, $strSymbol, $strPrice, $strSellQuantity, ByRef $iRemainQuantity)
	_yinheSendSellSymbol($hWnd, $idDebug, $strSymbol)
	$strPriceControl = 'Edit2'
	$strSuggestedPrice = _CtlGetText($hWnd, $idDebug, $strPriceControl)
	If $strPrice <> '' Then
		If $strSuggestedPrice <> $strPrice Then	_CtlSetText($hWnd, $idDebug, $strPriceControl, $strPrice)
	EndIf

	$iSell = _yinheSendSellQuantity($hWnd, $idDebug, $iRemainQuantity)
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

Func _yinheClickSell($hWnd, $idDebug)
	_yinheClickItem($hWnd, $idDebug, '卖出')
	_CtlWaitText($hWnd, $idDebug, 'Static9', '股东代码:')
	_CtlWaitText($hWnd, $idDebug, 'Static5', '卖出价格:')
	Return 'ComboBox3'
EndFunc

Func YinheSell($hWnd, $idDebug, $strSymbol, $strPrice, $strSellQuantity, ByRef $iRemainQuantity)
	$strHour = StringLeft(_NowTime(4), 2)
	_CtlDebug($idDebug, '当前小时：' & $strHour)

	$strControlID = _yinheClickSell($hWnd, $idDebug)
	While 1
		$iSel = 0
		$iTotal = 0
		While 1
			$strAccount = _CtlSelectString($hWnd, $idDebug, $strControlID, $iSel)
			If $strAccount == False Then ExitLoop

			_yinheCloseNewDlg($idDebug)
			If _isShenzhenAccount($strAccount) Then
				_CtlDebug($idDebug, '剩余卖出数量：' & String($iRemainQuantity))
				$iSold = _yinheAddShenzhenSellEntry($hWnd, $idDebug, $strSymbol, $strPrice, $strSellQuantity, $iRemainQuantity)
				$iTotal += $iSold
				If $iSold == -1 Then
					Return False
				ElseIf $iSold == 0 Then
					If Number($strHour) < 16 Then Return True	; 交易时间段不反复检查是否下单成功
;					ExitLoop
				EndIf
			EndIf
		WEnd
		_CtlDebug($idDebug, '下单数量：' & String($iTotal))
		If $iTotal == 0 Or Number($strHour) < 16 Then ExitLoop
	WEnd
	Return True
EndFunc

Func _yinheAddMoneyEntry($hWnd, $idDebug)
;	_yinheSendSellSymbol($hWnd, $idDebug, '131810')
	_yinheSendSellSymbol($hWnd, $idDebug, '204001')
	$strPriceControl = 'Edit2'
	$strSuggestedPrice = _CtlGetText($hWnd, $idDebug, $strPriceControl)
	$fPrice = Number($strSuggestedPrice, 3)
	$fPrice -= 0.1
	_CtlSetText($hWnd, $idDebug, $strPriceControl, String($fPrice))

	If _yinheSendSellQuantity($hWnd, $idDebug) Then
		_DlgClickButton($idDebug, '融券交易确认', '融券确认')
		_DlgClickButton($idDebug, '提示', '确认')
	EndIf
EndFunc

Func YinheMoney($hWnd, $idDebug)
	$strControlID = _yinheClickSell($hWnd, $idDebug)
	$iSel = 0
	While 1
		$strAccount = _CtlSelectString($hWnd, $idDebug, $strControlID, $iSel)
		If $strAccount == False Then ExitLoop

		_yinheCloseNewDlg($idDebug)
		If _isShanghaiAccount($strAccount) Then
;			If _isShanghaiFundAccount($strAccount) == False	Then
				_yinheAddMoneyEntry($hWnd, $idDebug)
				ExitLoop
;			EndIf
		EndIf
	WEnd
EndFunc

Func YinheCancelAll($hWnd, $idDebug, $strSymbol)
	_yinheClickItem($hWnd, $idDebug, '撤单')
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

Func YinheCash($hWnd, $idDebug, $strPassword)
	_yinheClickItem($hWnd, $idDebug, '资金划转', '银证转账')
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

Func _yinheAddOtherAccount($hWnd, $idDebug, $strAccount, $strPassword)
	WinActivate($hWnd)
    $arWinPos = WinGetPos($hWnd)
	$arPos = ControlGetPos($hWnd, '', 'ComboBox1')
	MouseClick($MOUSE_CLICK_PRIMARY, $arWinPos[0] + $arPos[0] - 10, $arWinPos[1] + $arPos[1] + 38)
	Sleep(1000)
	Send('{DOWN}')
	Sleep(1000)
	Send('{ENTER}')
	Sleep(1000)
	_yinheCloseNewDlg($idDebug)
	_yinheLoginDlg($idDebug, '添加帐号', $strAccount, $strPassword)
EndFunc

Func _debugProgress($idProgress, $iMax, $iCur)
	GUICtrlSetData($idProgress, Number(100 * ($iCur + 1) / $iMax))
EndFunc

Func YinheInquire($hWnd, $idProgress, $idDebug, Const ByRef $arAccountNumber, Const ByRef $arAccountPassword, Const ByRef $arAccountChecked, $iMax, $iCur)
	For $i = $iCur + 1 to $iMax - 1
		_debugProgress($idProgress, $iMax, $i)
		If $arAccountChecked[$i] == $GUI_CHECKED Then _yinheAddOtherAccount($hWnd, $idDebug, $arAccountNumber[$i], $arAccountPassword[$i])
	Next

	_yinheClickItem($hWnd, $idDebug, '查询', '当日委托')
	_CtlWaitText($hWnd, $idDebug, 'Button16', '按股票代码汇总')
	$strControl = 'Button17'
	_CtlWaitText($hWnd, $idDebug, $strControl, '按买卖方向汇总')
	ControlClick($hWnd, '', $strControl)
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

Func _yinheToggleAccount(Const ByRef $arCheckbox, $iMax)
	If $GUI_UNCHECKED == GUICtrlRead($arCheckbox[0], $GUI_READ_EXTENDED) Then
		$iState = $GUI_CHECKED
	Else
		$iState = $GUI_UNCHECKED
	EndIf

	For $i = 0 to $iMax - 1
		GUICtrlSetState($arCheckbox[$i], $iState)
	Next
EndFunc

Func _yinheLoadAccount()
	$iMax = _getProfileInt('AccountTotal')
	If $iMax == 0 Then
		$iMax = UBound($arPassword)		; get array size
		_putProfileInt('AccountTotal', $iMax)

		For $i = 0 to $iMax - 1
			$strIndex = String($i)
			_putProfileString('AccountNumber' & $strIndex, $arAccount[$i])
			_putProfileString('AccountPassword' & $strIndex, $arPassword[$i])
		Next
	EndIf
	Return $iMax
EndFunc

Func YinheOperation($idProgress, $idDebug)
	GUICtrlSetState($idProgress, $GUI_ENABLE)

	$iMax = _getProfileInt('AccountTotal')
	Local $arAccountNumber[$iMax]
	Local $arAccountPassword[$iMax]
	Local $arAccountChecked[$iMax]

	For $i = 0 to $iMax - 1
		$strIndex = String($i)
		$arAccountNumber[$i] = _getProfileString('AccountNumber' & $strIndex)
		$arAccountPassword[$i] = _getProfileString('AccountPassword' & $strIndex)
		$arAccountChecked[$i] = _getProfileInt('AccountState' & $strIndex)
	Next

	$strSymbol = _getProfileString('Symbol')
	$strSellQuantity = _getProfileString('SellQuantity')
	$iRemainQuantity = Number($strSellQuantity) + 50
	For $i = 0 to $iMax - 1
		_debugProgress($idProgress, $iMax, $i)
		If $arAccountChecked[$i] == $GUI_CHECKED Then
			_GUICtrlListBox_ResetContent($idDebug)
			$strPassword = $arAccountPassword[$i]
			$hWnd = YinheLogin($idDebug, $arAccountNumber[$i], $strPassword)
			If _getProfileInt('Order') == $GUI_CHECKED Then
				YinheOrderFund($hWnd, $idDebug, $strSymbol)
			ElseIf _getProfileInt('Redeem') == $GUI_CHECKED Then
				If YinheRedeemFund($hWnd, $idDebug, $strSymbol, $strSellQuantity, $iRemainQuantity) == False Then
					YinheClose($hWnd, $idDebug)
					ExitLoop
				EndIf
			ElseIf _getProfileInt('Sell') == $GUI_CHECKED Then
				If YinheSell($hWnd, $idDebug, $strSymbol, _getProfileString('SellPrice'), $strSellQuantity, $iRemainQuantity) == False Then
					YinheClose($hWnd, $idDebug)
					ExitLoop
				EndIf
			ElseIf _getProfileInt('Money') == $GUI_CHECKED Then
				YinheMoney($hWnd, $idDebug)
			ElseIf _getProfileInt('Cash') == $GUI_CHECKED Then
				YinheCash($hWnd, $idDebug, $strPassword)
			ElseIf _getProfileInt('Cancel') == $GUI_CHECKED Then
				YinheCancelAll($hWnd, $idDebug, $strSymbol)
			ElseIf _getProfileInt('Login') == $GUI_CHECKED Then
				YinheInquire($hWnd, $idProgress, $idDebug, $arAccountNumber, $arAccountPassword, $arAccountChecked, $iMax, $i)
				ExitLoop
			EndIf
			YinheClose($hWnd, $idDebug)
		EndIf
	Next

	If $strSellQuantity <> '' Then
		$iQuantity = Number($strSellQuantity) - $iRemainQuantity + 50
		If $iQuantity <> 0 Then _MsgDebug('实际下单：' & String($iQuantity))
	EndIf

	GUICtrlSetData($idProgress, 0)
	GUICtrlSetState($idProgress, $GUI_DISABLE)
EndFunc

Func _getSelectedPassword($idSelectedItem, Const ByRef $arCheckboxAccount, $iMax)
	Return _getProfileString('AccountPassword' & String(_getSelectedListViewIndex($idSelectedItem, $arCheckboxAccount, $iMax)))
EndFunc

Func _getSelectedAccount($idSelectedItem, Const ByRef $arCheckboxAccount, $iMax)
	Return _getProfileString('AccountNumber' & String(_getSelectedListViewIndex($idSelectedItem, $arCheckboxAccount, $iMax)))
EndFunc

Func _getSelectedListViewIndex($idSelectedItem, Const ByRef $arCheckboxAccount, $iMax)
	For $i = 0 to $iMax - 1
		If $idSelectedItem == $arCheckboxAccount[$i] Then ExitLoop
	Next
	Return $i
EndFunc

Func _onNewAccount($idDebug, ByRef $iMax, $strDlgAccount, $strDlgPassword)
	$strIndex = String($iMax)
	$iMax += 1
	_putProfileInt('AccountTotal', $iMax)
	_CtlDebug($idDebug, '新账号： ' & $strDlgAccount)
	_putProfileString('AccountNumber' & $strIndex, $strDlgAccount)
	_putProfileString('AccountPassword' & $strIndex, $strDlgPassword)
EndFunc

Func _onEditAccount($idDebug, $iIndex, $strDlgAccount, $strDlgPassword)
	$strPasswordName = 'AccountPassword' & String($iIndex)
	If $strDlgPassword <> _getProfileString($strPasswordName) Then
		_CtlDebug($idDebug, '密码更改')
		_putProfileString($strPasswordName, $strDlgPassword)
	EndIf

	$strAccountName = 'AccountNumber' & String($iIndex)
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

Func _loadListViewAccount($idListViewAccount, ByRef $arCheckboxAccount, $iMax)
	For $i = 0 to $iMax - 1
		$strIndex = String($i)
		$arCheckboxAccount[$i] = GUICtrlCreateListViewItem(_getProfileString('AccountNumber' & $strIndex), $idListViewAccount)
		GUICtrlSetState(-1, _getProfileInt('AccountState' & $strIndex, $GUI_CHECKED))
	Next
EndFunc

Func YinheMain()
	$iMax = _yinheLoadAccount()
	Local $arCheckboxAccount[$iMax]
	$iMsg = 0

	$idFormMain = GUICreate("银河海王星单独委托版全自动拖拉机V0.61", 803, 506, 289, 0)

	$idListViewAccount = GUICtrlCreateListView("客户号", 24, 24, 146, 454, BitOR($GUI_SS_DEFAULT_LISTVIEW,$WS_VSCROLL), BitOR($WS_EX_CLIENTEDGE,$LVS_EX_CHECKBOXES))
	GUICtrlSendMsg(-1, $LVM_SETCOLUMNWIDTH, 0, 118)
	_loadListViewAccount($idListViewAccount, $arCheckboxAccount, $iMax)

	$idMenuAccount = GUICtrlCreateContextMenu($idListViewAccount)
	$idMenuEdit = GUICtrlCreateMenuItem('添加或者修改选中客户号', $idMenuAccount)
	$idMenuDel = GUICtrlCreateMenuItem('清除全部客户号记录', $idMenuAccount)

	$idLabelSymbol = GUICtrlCreateLabel("基金代码", 192, 24, 52, 17)
	$idListSymbol = GUICtrlCreateList("", 192, 48, 121, 97)
	GUICtrlSetData(-1, '160216|160416|161127|161226|162411|163208|164906', _getProfileString('Symbol', '162411'))

	$idLabelSellPrice = GUICtrlCreateLabel("卖出价格", 192, 160, 52, 17)
	$idInputSellPrice = GUICtrlCreateInput("", 192, 184, 121, 21)
	GUICtrlSetData(-1, _getProfileString('SellPrice'))

	$idLabelSellQuantity = GUICtrlCreateLabel("卖出或者赎回总数量", 192, 224, 112, 17)
	$idInputSellQuantity = GUICtrlCreateInput("", 192, 248, 121, 21)
	GUICtrlSetData(-1, _getProfileString('SellQuantity'))

	$GroupOperation = GUICtrlCreateGroup("操作", 192, 288, 121, 193)
	$RadioCash = GUICtrlCreateRadio("转账回银行", 208, 312, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioCash, $iMsg, 'Cash', $GUI_UNCHECKED))
	$RadioMoney = GUICtrlCreateRadio("逆回购", 208, 336, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioMoney, $iMsg, 'Money', $GUI_UNCHECKED))
	$RadioOrder = GUICtrlCreateRadio("场内申购", 208, 360, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioOrder, $iMsg, 'Order', $GUI_CHECKED))
	$RadioRedeem = GUICtrlCreateRadio("赎回", 208, 384, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioRedeem, $iMsg, 'Redeem', $GUI_UNCHECKED))
	$RadioSell = GUICtrlCreateRadio("卖出", 208, 408, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioSell, $iMsg, 'Sell', $GUI_UNCHECKED))
	$RadioCancel = GUICtrlCreateRadio("全部撤单", 208, 432, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioCancel, $iMsg, 'Cancel', $GUI_UNCHECKED))
	$RadioLogin = GUICtrlCreateRadio("仅登录查询", 208, 456, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioLogin, $iMsg, 'Login', $GUI_UNCHECKED))
	GUICtrlCreateGroup("", -99, -99, 1, 1)

	$idProgressDebug = GUICtrlCreateProgress(336, 24, 438, 17)
	GUICtrlSetState(-1, $GUI_DISABLE)
	$idListDebug = GUICtrlCreateList("", 336, 48, 441, 383, BitOR($LBS_NOTIFY,$LBS_MULTIPLESEL,$WS_VSCROLL,$WS_BORDER))
	$idMenuDebug = GUICtrlCreateContextMenu($idListDebug)
	$idMenuCopy = GUICtrlCreateMenuItem('复制到剪贴板', $idMenuDebug)

	$idButtonRun = GUICtrlCreateButton("执行自动操作(&R)", 336, 456, 107, 25)
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

			Case $idListViewAccount
				_yinheToggleAccount($arCheckboxAccount, $iMax)

			Case $idButtonRun
				For $i = 0 to $iMax - 1
					_putProfileInt('AccountState' & String($i), GUICtrlRead($arCheckboxAccount[$i], $GUI_READ_EXTENDED))
				Next
				_putProfileString('Symbol', GUICtrlRead($idListSymbol))
				_putProfileInt('Cash', GUICtrlRead($RadioCash))
				_putProfileInt('Money', GUICtrlRead($RadioMoney))
				_putProfileInt('Order', GUICtrlRead($RadioOrder))
				_putProfileInt('Redeem', GUICtrlRead($RadioRedeem))
				_putProfileInt('Sell', GUICtrlRead($RadioSell))
				_putProfileInt('Cancel', GUICtrlRead($RadioCancel))
				_putProfileInt('Login', GUICtrlRead($RadioLogin))
				_putProfileString('SellPrice', GUICtrlRead($idInputSellPrice))
				_putProfileString('SellQuantity', GUICtrlRead($idInputSellQuantity))
				GUICtrlSetState($idButtonRun, $GUI_DISABLE)
				GUICtrlSetState($idListViewAccount, $GUI_DISABLE)
				GUICtrlSetState($idListDebug, $GUI_DISABLE)
				YinheOperation($idProgressDebug, $idListDebug)
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
					$strDlgPassword = _getSelectedPassword($idSelectedItem, $arCheckboxAccount, $iMax)
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
								_onNewAccount($idListDebug, $iMax, $strDlgAccount, $strDlgPassword)
								ReDim $arCheckboxAccount[$iMax]
								$arCheckboxAccount[$iMax - 1] = GUICtrlCreateListViewItem($strDlgAccount, $idListViewAccount)
								GUICtrlSetState(-1, $GUI_CHECKED)
							Else
								$iIndex = _getSelectedListViewIndex($idSelectedItem, $arCheckboxAccount, $iMax)
								If _onEditAccount($idListDebug, $iIndex, $strDlgAccount, $strDlgPassword) Then
									_GUICtrlListView_DeleteAllItems($idListViewAccount)
									_loadListViewAccount($idListViewAccount, $arCheckboxAccount, $iMax)
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

	YinheMain()
