#cs
	Title:   		拖拉机自动化
	Filename:  		yinhe.au3
	Description: 	拖拉机账户自动申购，卖出，逆回购和银证转账回银行。
	Author:   		Woody Lin
	Version:  		V0.1
	Last Update: 	2020/10/25
	Requirements: 	AutoIt3 3.3 or higher,
	Changelog:		---------2020/10/25---------- V0.1
					Initial release.

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
#include <StaticConstants.au3>
#include <WindowsConstants.au3>

#include <GuiTreeView.au3>
#include <GuiListView.au3>
#include <Tesseract.au3>
#include <yinheaccounts.au3>

#cs
#include <ScreenCapture.au3>
#include <Array.au3> ; Required for _ArrayDisplay() only.

Func _getPixelGrayLevel($x, $y)
	$iColor = PixelGetColor($x, $y)
	$r = Number($iColor / 65536, 1)
	$g = Number(($iColor - $r * 65536) / 256, 1)
	$b = $iColor - $r * 65536 - $g * 256
	Return Number(0.299 * $r + 0.587 * $g + 0.114 * $b + 0.5, 1)
EndFunc

Func _getVerticalLineColor($iHorz, $iTop, $iBottom)
	Dim $arColor[18]
	For $i = 0 to $iBottom - $iTop Step 1
		$arColor[$i] = _getPixelGrayLevel($iHorz, $i + $iTop)
	Next
	Return $arColor
EndFunc

Func _isBackGroundLine($arColor, $iBackColor)
	for $iColor in $arColor
		If Abs($iColor - $iBackColor) > 24 Then
			Return False
		EndIf
	Next
	Return True
EndFunc

Func _adjustHeight($iTotal, $iHeight)
	Return Number(14.0 * $iTotal / $iHeight / $iHeight + 0.5, 1)
EndFunc

Func _getVerifyDigit(ByRef $iHorz, $iTop, $iBottom, $iBackColor)
	Dim $arVertTotal[18]
	Dim $arVertPixel[18]
	$iTotal = 0
	$iTotalPixel = 0
	$iMax = 9
	$iMin = 9
	$i = 1
	Do
		$arColor = _getVerticalLineColor($iHorz, $iTop, $iBottom)
;		_ArrayDisplay($arColor)
		If _isBackGroundLine($arColor, $iBackColor) Then
			If $iTotal <> 0 Then ExitLoop
		Else
			$arVertTotal[$i] = 0
			$iVertCount = 1
			for $iColor in $arColor
				If Abs($iColor - $iBackColor) > 24 Then
					$arVertTotal[$i] += $i
					$arVertTotal[$i] += $iVertCount
					$arVertPixel[$i] += 1
					If $iVertCount < $iMin Then $iMin = $iVertCount
					If $iVertCount > $iMax Then $iMax = $iVertCount
				EndIf
				$iVertCount += 1
			Next
			$iTotal += $arVertTotal[$i]
			$iTotalPixel += $arVertPixel[$i]
			$i += 1
		EndIf
		$iHorz += 1
	Until False

	$iHalfTotal = 0
	$iHalf = Number(($i - 1) / 2, 1)
	For $i = 1 to $iHalf Step 1
		$iHalfTotal += $arVertTotal[$i] - ($iMin - 1) * $arVertPixel[$i]
	Next

	$iHeight = $iMax - $iMin + 1
	$iHalfTotal = _adjustHeight($iHalfTotal, $iHeight)

	$iTotal -= ($iMin - 1) * $iTotalPixel
	$iTotal = _adjustHeight($iTotal, $iHeight)
	Return String($iTotal) & "/" & String($iHalfTotal) & " "
EndFunc
#ce

Func _getVerifyCode($iLeft, $iTop, $iRight, $iBottom)
#cs
	_ScreenCapture_Capture("C:\temp\GDIPlus_Image2.jpg", $iLeft, $iTop, $iRight, $iBottom)

	$iBackColor = _getPixelGrayLevel($iRight, $iBottom)
	$iHorz = $iLeft
	$strCode = ""
	For $i = 0 to 3 Step 1
		$strCode = $strCode & _getVerifyDigit($iHorz, $iTop, $iBottom, $iBackColor)
	Next
#ce
	Local $strCode = _TesseractScreenCapture(0, "", 1, 2, $iLeft, $iTop, $iRight, $iBottom)
	Return $strCode
EndFunc

Func _DebugBox($str)
	MsgBox($MB_ICONINFORMATION, "拖拉机暂停中", $str)
EndFunc

Func _CtlSendString($hWnd, $strControl, $str)
	While $str <> ControlGetText($hWnd, "", $strControl)
		ControlSetText($hWnd, "", $strControl, $str)
		Sleep(1000)
	WEnd
EndFunc

Func _CtlGetText($hWnd, $strControl)
	Local $str
	Do
		$str = ControlGetText($hWnd, "", $strControl)
;		_DebugBox($str)
	Until $str <> ""
	Return $str
EndFunc

Func _DlgClickButton($strTitle, $strButton)
;	ConsoleWrite("@@ Debug(" & @ScriptLineNumber & ")" & "等待对话框" & $strTitle & "和按钮" & $strButton & @CRLF)
	Local $hDlgWnd = WinWait($strTitle, $strButton, 5)
	If $hDlgWnd <> 0 Then
		WinActivate($hDlgWnd)
		ControlClick($hDlgWnd, "", "[CLASS:Button; TEXT:" & $strButton & "]")
		Sleep(1000)
	Else
		_DebugBox(String($hDlgWnd) & "--5秒内没找到对话框" & $strTitle & "和按钮" & $strButton)
	EndIf
EndFunc

Func _yinheLoginDlg($hWnd, $strAcount, $strPassword)
	_CtlSendString($hWnd, "Edit1", $strAcount)
	ControlFocus($hWnd, "", "AfxWnd421")
	Send($strPassword)

	Local $strControl = "Edit2"
    Local $arWinPos = WinGetPos($hWnd)
	Local $arPos = ControlGetPos($hWnd, "", $strControl)
	Local $iLeft = $arWinPos[0] + $arPos[0] + $arPos[2] + 6
	Local $iTop = $arWinPos[1] + $arPos[1] + 1
	Local $iRight = $arWinPos[0] + $arWinPos[2] - 29
	Local $iBottom = $arWinPos[1] + $arPos[1] + $arPos[3] - 3

	Local $iCheckSum = PixelChecksum($iLeft, $iTop, $iRight, $iBottom)
	Local $iCount = 0
	Do
		Local $strCode = "4321"
		If $iCount == 0 Then
			Local $strVerifyCode = _getVerifyCode($iLeft, $iTop, $iRight, $iBottom)
			If $strVerifyCode == "" Then
				$strCode = "1234"
			Else
				$strCode = StringReplace($strVerifyCode, "Z", "2")
			EndIf
		EndIf

		ControlFocus($hWnd, "", $strControl)
		ControlSend($hWnd, "", $strControl, $strCode)
		Sleep(1000)
		ControlClick($hWnd, "", "Button1")	;确认

		Do
			Sleep(100)
			Local $iNewCheckSum = PixelChecksum($iLeft, $iTop, $iRight, $iBottom)
			If $iNewCheckSum <> $iCheckSum	Then
				$iCheckSum = $iNewCheckSum
				$iCount = 0
				ExitLoop
			Else
				$iCount += 1
			EndIf
		Until $iCount == 10
	Until ControlCommand($hWnd, "", "ComboBox4", "IsEnabled") == 0

	Local $iTimeOut = 1
	While 1
		$hWnd = WinWait("通达信网上交易V6", $strAcount, $iTimeOut)
		If $hWnd <> 0 Then
			WinActivate($hWnd)
			ExitLoop
		EndIf

		Local $hMsgWnd = WinGetHandle("消息标题", "今日不再提示")
		If @error Then
		Else
			WinActivate($hMsgWnd)
			ControlClick($hMsgWnd, "", "Button3")	;关闭
			Sleep(1000)
			$iTimeOut = 0
		EndIf
	WEnd
	Return $hWnd
EndFunc

Func YinheLogin($strAcount, $strPassword)
	Run("C:\中国银河证券海王星独立交易\Tc.exe", "C:\中国银河证券海王星独立交易\")
	Local $hWnd = WinWaitActive("通达信网上交易", "验证码")
	Return _yinheLoginDlg($hWnd, $strAcount, $strPassword)
EndFunc

Func YinheClose($hWnd)
	Sleep(1000)
	WinClose($hWnd)
	_DlgClickButton("退出确认", "退出系统")
EndFunc

Func _addSymbolSpecialKey($strSymbol)
	If $strSymbol == "160216" Or $strSymbol == "160416" Then
		_DlgClickButton("请选择", "深圳股票")
	EndIf
EndFunc

Func _yinheAddShenzhenOrderEntry($hWnd, $strControlID, $strAccount, $strSymbol, $strAmount)
	ControlFocus($hWnd, "", "Edit1")
	ControlSend($hWnd, "", "Edit1", $strSymbol)
	Sleep(1000)
	_addSymbolSpecialKey($strSymbol)

	ControlCommand($hWnd, "", $strControlID, "SelectString", $strAccount)

	Local $strCash
	Do
		$strCash = ControlGetText($hWnd, "", "Static6")
	Until $strCash <> ""
	If Number($strCash, 3) < Number($strAmount, 3) Then
		_DebugBox($strSymbol & "申购资金不足")
		Return False
	EndIf

	_CtlSendString($hWnd, "Edit2", $strAmount)
	ControlClick($hWnd, "", "Button1")
	Sleep(1000)
	_DlgClickButton("基金风险揭示", "我已阅读并同意签署")

	Local $hFileWnd = WinWait("基金概要文件", "本人已认真阅读并确认上述内容", 10)
	If $hFileWnd <> 0 Then
		WinActivate($hFileWnd)
		ControlClick($hFileWnd, "", "Button11")	;本人已认真阅读并确认上述内容
		Sleep(1000)
		ControlClick($hFileWnd, "", "Button1")	;确认
		Sleep(1000)
	EndIf

	_DlgClickButton("提示信息", "确认")
	_DlgClickButton("提示", "确认")
	_DlgClickButton("提示", "确认")
	Return True
EndFunc

Func _isShenzhenAccount($strAccount)
	If StringInStr($strAccount, "深") == 1 Then Return True
	Return False
EndFunc

Func _isShenzhenFundAccount($strAccount)
	If StringInStr($strAccount, "深A 05") == 1 Then Return True
	Return False
EndFunc

Func _yinheAddOrderEntry($hWnd, $strControlID, $strAccount, $strSymbol, $strAmount)
	If _isShenzhenAccount($strAccount) Then
		Return _yinheAddShenzhenOrderEntry($hWnd, $strControlID, $strAccount, $strSymbol, $strAmount)
	EndIf
	Return True
EndFunc

Func _yinheClickItem($hWnd, $strLevel1, $strLevel2 = False)
	Local $strControlID = "SysTreeView321"
	ControlFocus($hWnd, "", $strControlID)
	Sleep(1000)
	ControlTreeView($hWnd, "", $strControlID, "Select", $strLevel1)
	Sleep(1000)
	If $strLevel2 <> False	Then
		ControlTreeView($hWnd, "", $strControlID, "Expand", $strLevel1)
		Sleep(1000)
		ControlTreeView($hWnd, "", $strControlID, "Select", $strLevel1 & "|" & $strLevel2)
		Sleep(1000)
	EndIf

	Local $hCtrl = ControlGetHandle($hWnd, "", $strControlID)
	Local $hItem = _GUICtrlTreeView_GetSelection($hCtrl)	;Get currently selected TreeView item
	_GUICtrlTreeView_ClickItem($hCtrl, $hItem)				;perform a single click
	Sleep(1000)
EndFunc

Func YinheOrderFund($hWnd, $strSymbol)
	_yinheClickItem($hWnd, "场内开放式基金", "基金申购")

	Local $strAmount
	Switch $strSymbol
		Case "160216"
			$strAmount = "10000"
		Case "160416"
			$strAmount = "2000"
		Case "162411"
			$strAmount = "100"
	EndSwitch

	Local $strControlID = "ComboBox2"
	Local $iSel = 0
	While 1
		ControlCommand($hWnd, "", $strControlID, "SetCurrentSelection", $iSel)
		If @error Then ExitLoop
		Local $strSel = ControlGetText($hWnd, "", $strControlID)
		If _yinheAddOrderEntry($hWnd, $strControlID, $strSel, $strSymbol, $strAmount) == False Then ExitLoop
		$iSel += 1
	WEnd
EndFunc

Func _yinheSendSellSymbol($hWnd, $strSymbol)
	Local $strControl = "AfxWnd423"
	If $strSymbol <> ControlGetText($hWnd, "", $strControl) Then
		ControlFocus($hWnd, "", $strControl)
		ControlSend($hWnd, "", $strControl, $strSymbol)
		Sleep(1000)
	EndIf

	_addSymbolSpecialKey($strSymbol)

	Local $strQuantity = _CtlGetText($hWnd, "Static8")
	If $strQuantity <> "0" Then
		_CtlSendString($hWnd, "Edit5", $strQuantity)
		Return True
	EndIf
	Return False
EndFunc

Func _yinheAddShenzhenSellEntry($hWnd, $strSymbol, $strPrice)
	If _yinheSendSellSymbol($hWnd, $strSymbol) Then
		Local $strPriceControl = "Edit2"
		Local $strSuggestedPrice = _CtlGetText($hWnd, $strPriceControl)
		If $strPrice <> "" Then
			If $strSuggestedPrice <> $strPrice Then	_CtlSendString($hWnd, $strPriceControl, $strPrice)
		EndIf
		ControlClick($hWnd, "", "Button1")
		Sleep(1000)
		_DlgClickButton("卖出交易确认", "卖出确认")
		_DlgClickButton("提示", "确认")
	EndIf
EndFunc

Func _yinheAddSellEntry($hWnd, $strAccount, $strSymbol, $strPrice)
	If _isShenzhenAccount($strAccount) Then
		_yinheAddShenzhenSellEntry($hWnd, $strSymbol, $strPrice)
	EndIf
EndFunc

Func YinheSell($hWnd, $strSymbol, $strPrice)
	_yinheClickItem($hWnd, "卖出")
	Local $strControlID = "ComboBox3"
	Local $iSel = 0
	While 1
		ControlCommand($hWnd, "", $strControlID, "SetCurrentSelection", $iSel)
		If @error Then ExitLoop
		Local $strSel = ControlGetText($hWnd, "", $strControlID)
		_yinheAddSellEntry($hWnd, $strSel, $strSymbol, $strPrice)
		$iSel += 1
	WEnd
EndFunc

Func _yinheAddShenzhenMoneyEntry($hWnd)
	If _yinheSendSellSymbol($hWnd, "131810") Then
		Local $strPriceControl = "Edit2"
		Local $strSuggestedPrice = _CtlGetText($hWnd, $strPriceControl)
		Local $fPrice = Number($strSuggestedPrice, 3)
		$fPrice -= 0.1
		_CtlSendString($hWnd, $strPriceControl, String($fPrice))
		ControlClick($hWnd, "", "Button1")
		Sleep(1000)
		_DlgClickButton("融券交易确认", "融券确认")
		_DlgClickButton("提示", "确认")
	EndIf
EndFunc

Func _yinheAddMoneyEntry($hWnd, $strAccount)
	If _isShenzhenAccount($strAccount) Then
		If _isShenzhenFundAccount($strAccount) == False	Then
			_yinheAddShenzhenMoneyEntry($hWnd)
			Return True
		EndIf
	EndIf
	Return False
EndFunc

Func YinheMoney($hWnd)
	_yinheClickItem($hWnd, "卖出")
	Local $strControlID = "ComboBox3"
	Local $iSel = 0
	While 1
		ControlCommand($hWnd, "", $strControlID, "SetCurrentSelection", $iSel)
		If @error Then ExitLoop
		Local $strSel = ControlGetText($hWnd, "", $strControlID)
		If _yinheAddMoneyEntry($hWnd, $strSel)	Then ExitLoop
		$iSel += 1
	WEnd
EndFunc

Func YinheCancelAll($hWnd)
	_yinheClickItem($hWnd, "撤单")
;	Local $idListView = ControlGetHandle($hWnd, "", "SysListView321")
;	Local $str = _GUICtrlListView_GetItemText($idListView, 1)
;	_DebugBox($str)

	If _CtlGetText($hWnd, "Static12") <> "共0条" Then
		ControlClick($hWnd, "", "Button4")
		Sleep(1000)
		ControlClick($hWnd, "", "Button1")
		Sleep(1000)
		_DlgClickButton("提示", "确认")
		_DlgClickButton("提示", "确认")
	EndIf
EndFunc

Func YinheCash($hWnd, $strPassword)
	_yinheClickItem($hWnd, "资金划转", "银证转账")
	ControlCommand($hWnd, "", "ComboBox2", "SetCurrentSelection", 1)
	Local $iCount = 0
	Local $strCash
	Do
		Sleep(100)
		$iCount += 1
		If $iCount > 50	Then Return
		$strCash = ControlGetText($hWnd, "", "Static13")
	Until $strCash <> ""
	If Number($strCash, 3) > 0.009 Then
		ControlFocus($hWnd, "", "AfxWnd424")
		Send($strPassword)
		Sleep(1000)
		_CtlSendString($hWnd, "Edit1", $strCash)
		ControlClick($hWnd, "", "Button1")
		Sleep(1000)
		_DlgClickButton("确认提示", "确认")
		_DlgClickButton("提示", "确认")
	EndIf
EndFunc

Func _yinheAddOtherAccount($hWnd, $strAcount, $strPassword)
    Local $arWinPos = WinGetPos($hWnd)
	Local $arPos = ControlGetPos($hWnd, "", "ComboBox1")
	MouseClick($MOUSE_CLICK_PRIMARY, $arWinPos[0] + $arPos[0] - 10, $arWinPos[1] + $arPos[1] + 38)
	Sleep(1000)
	Send("{DOWN}")
	Sleep(1000)
	Send("{ENTER}")
	Sleep(1000)
	Local $hDlgWnd = WinWaitActive("添加帐号", "验证码")
	_yinheLoginDlg($hDlgWnd, $strAcount, $strPassword)
EndFunc

Func YinheInquire($hWnd, Const ByRef $arAccountNumber, Const ByRef $arAccountPassword, Const ByRef $arAccountChecked, $iMax, $iCur)
	Local $i
	For $i = $iCur + 1 to $iMax - 1
		If $arAccountChecked[$i] == $GUI_CHECKED Then _yinheAddOtherAccount($hWnd, $arAccountNumber[$i], $arAccountPassword[$i])
	Next

	_yinheClickItem($hWnd, "查询", "当日委托")
	ControlClick($hWnd, "", "Button17")	;按买卖方向汇总
EndFunc

Func _hotKeyPressed()
    Switch @HotKeyPressed ; The last hotkey pressed.
        Case "{ESC}" ; String is the {ESC} hotkey.
            Exit
    EndSwitch
EndFunc

const $strRegKey = "HKEY_CURRENT_USER\Software\AutoIt_yinhe"

Func _getProfileString($strValName, $strDefault = "", $strKeyName = $strRegKey)
	Local $strVal = RegRead($strKeyName, $strValName)
	If @error Or @extended <> $REG_SZ Then Return $strDefault
	Return $strVal
EndFunc

Func _putProfileString($strValName, $strVal, $strKeyName = $strRegKey)
	RegWrite($strKeyName, $strValName, "REG_SZ", $strVal)
EndFunc

Func _getProfileInt($strValName, $iDefault = 0, $strKeyName = $strRegKey)
	Local $iVal = RegRead($strKeyName, $strValName)
	If @error Or @extended <> $REG_DWORD Then Return $iDefault
	Return $iVal
EndFunc

Func _putProfileInt($strValName, $iVal, $strKeyName = $strRegKey)
	RegWrite($strKeyName, $strValName, "REG_DWORD", $iVal)
EndFunc

Func _getRadioState($idRadio, ByRef $iMsg, $strValName, $iDefault)
	Local $iState = _getProfileInt($strValName, $iDefault)
	If $iState == $GUI_CHECKED Then $iMsg = $idRadio
	Return $iState
EndFunc

Func _yinheToggleAccount(Const ByRef $arCheckbox, $iMax)
	Local $iState
	If $GUI_UNCHECKED == GUICtrlRead($arCheckbox[0], $GUI_READ_EXTENDED) Then
		$iState = $GUI_CHECKED
	Else
		$iState = $GUI_UNCHECKED
	EndIf

	Local $i
	For $i = 0 to $iMax - 1
		GUICtrlSetState($arCheckbox[$i], $iState)
	Next
EndFunc

Func _yinheGUI()
	Local $i
	Local $strIndex
	Local $iMax = _getProfileInt("AccountTotal")
	If $iMax == 0 Then
		$iMax = UBound($arPassword)		; get array size
		_putProfileInt("AccountTotal", $iMax)

		For $i = 0 to $iMax - 1
			$strIndex = String($i)
			_putProfileString("AccountNumber" & $strIndex, $arAccount[$i])
			_putProfileString("AccountPassword" & $strIndex, $arPassword[$i])
		Next
	EndIf

	Local $arCheckboxAccount[$iMax]
	Local $iMsg = 0

	$Form1_1 = GUICreate("银河海王星全自动拖拉机", 316, 474, 707, 242)
	$LabelSymbol = GUICtrlCreateLabel("基金代码", 168, 24, 52, 17)
	$ListSymbol = GUICtrlCreateList("", 168, 48, 121, 97)
	GUICtrlSetData(-1, "160216|160416|162411", _getProfileString("Symbol", "162411"))

	$GroupOperation = GUICtrlCreateGroup("操作", 168, 160, 121, 169)
	$RadioCash = GUICtrlCreateRadio("转账回银行", 184, 184, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioCash, $iMsg, "Cash", $GUI_UNCHECKED))
	$RadioMoney = GUICtrlCreateRadio("深市逆回购", 184, 208, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioMoney, $iMsg, "Money", $GUI_UNCHECKED))
	$RadioOrder = GUICtrlCreateRadio("场内申购", 184, 232, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioOrder, $iMsg, "Order", $GUI_CHECKED))
	$RadioSell = GUICtrlCreateRadio("卖出", 184, 256, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioSell, $iMsg, "Sell", $GUI_UNCHECKED))
	$RadioCancel = GUICtrlCreateRadio("全部撤单", 184, 280, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioCancel, $iMsg, "Cancel", $GUI_UNCHECKED))
	$RadioLogin = GUICtrlCreateRadio("仅登录查询", 184, 304, 89, 17)
	GUICtrlSetState(-1, _getRadioState($RadioLogin, $iMsg, "Login", $GUI_UNCHECKED))
    GUICtrlCreateGroup("", -99, -99, 1, 1) ;close group

	$LabelSellPrice = GUICtrlCreateLabel("卖出价格", 168, 352, 52, 17)
	$InputSellPrice = GUICtrlCreateInput("", 168, 376, 121, 21)
	GUICtrlSetData(-1, _getProfileString("SellPrice"))

	$ListViewAccount = GUICtrlCreateListView("客户号", 24, 24, 122, 374, -1, BitOR($WS_EX_CLIENTEDGE,$LVS_EX_CHECKBOXES))
	GUICtrlSendMsg(-1, $LVM_SETCOLUMNWIDTH, 0, 118)
	For $i = 0 to $iMax - 1
		$strIndex = String($i)
		$arCheckboxAccount[$i] = GUICtrlCreateListViewItem(_getProfileString("AccountNumber" & $strIndex), $ListViewAccount)
		GUICtrlSetState(-1, _getProfileInt("AccountState" & $strIndex, $GUI_CHECKED))
	Next

	$idTrackMenu = GUICtrlCreateContextMenu($ListViewAccount)
	$idMenuEdit = GUICtrlCreateMenuItem("添加或者修改选中客户号", $idTrackMenu)
	$idMenuDel = GUICtrlCreateMenuItem("清除全部客户号记录", $idTrackMenu)

	$ButtonOK = GUICtrlCreateButton("执行自动操作", 200, 424, 91, 25)
	GUICtrlSetState(-1, $GUI_FOCUS)
	GUISetState(@SW_SHOW)

	While 1
		Switch $iMsg
			Case $idMenuDel
				If MsgBox($MB_ICONQUESTION + $MB_YESNO, "无法恢复的操作", "确定清除全部客户号记录并且退出？") == $IDYES Then
					RegDelete($strRegKey)
					Exit
				EndIf

			Case $idMenuEdit
;				_DebugBox("代码完善中...")
				Local $idSelectedItem = GUICtrlRead($ListViewAccount)
				If $idSelectedItem == 0 Then
					MsgBox($MB_ICONINFORMATION, "新建", "没有找到选中的客户号")
				Else
					MsgBox($MB_ICONINFORMATION, "修改", GUICtrlRead($idSelectedItem))
				EndIf

			Case $RadioCash, $RadioMoney, $RadioCancel, $RadioLogin
				If GUICtrlRead($iMsg) == $GUI_CHECKED Then
					GUICtrlSetState($InputSellPrice, $GUI_DISABLE)
					GUICtrlSetState($ListSymbol, $GUI_DISABLE)
				EndIf

			Case $RadioOrder
				If GUICtrlRead($RadioOrder) == $GUI_CHECKED Then
					GUICtrlSetState($InputSellPrice, $GUI_DISABLE)
					GUICtrlSetState($ListSymbol, $GUI_ENABLE)
				EndIf

			Case $RadioSell
				If GUICtrlRead($RadioSell) == $GUI_CHECKED Then
					GUICtrlSetState($InputSellPrice, $GUI_ENABLE)
					GUICtrlSetState($ListSymbol, $GUI_ENABLE)
				EndIf

			Case $ListViewAccount
				_yinheToggleAccount($arCheckboxAccount, $iMax)

			Case $ButtonOK
				ExitLoop

			Case $GUI_EVENT_CLOSE
				Exit
		EndSwitch
		$iMsg = GUIGetMsg()
	WEnd

	For $i = 0 to $iMax - 1
		_putProfileInt("AccountState" & String($i), GUICtrlRead($arCheckboxAccount[$i], $GUI_READ_EXTENDED))
	Next
	_putProfileString("Symbol", GUICtrlRead($ListSymbol))
	_putProfileInt("Cash", GUICtrlRead($RadioCash))
	_putProfileInt("Money", GUICtrlRead($RadioMoney))
	_putProfileInt("Order", GUICtrlRead($RadioOrder))
	_putProfileInt("Sell", GUICtrlRead($RadioSell))
	_putProfileInt("Cancel", GUICtrlRead($RadioCancel))
	_putProfileInt("Login", GUICtrlRead($RadioLogin))
	_putProfileString("SellPrice", GUICtrlRead($InputSellPrice))
	GUIDelete()
EndFunc

Func YinheMain()
	HotKeySet("{ESC}", "_hotKeyPressed")
	_yinheGUI()

	Local $iMax = _getProfileInt("AccountTotal")
	Local $arAccountNumber[$iMax]
	Local $arAccountPassword[$iMax]
	Local $arAccountChecked[$iMax]

	Local $i
	For $i = 0 to $iMax - 1
		Local $strIndex = String($i)
		$arAccountNumber[$i] = _getProfileString("AccountNumber" & $strIndex)
		$arAccountPassword[$i] = _getProfileString("AccountPassword" & $strIndex)
		$arAccountChecked[$i] = _getProfileInt("AccountState" & $strIndex)
	Next
	Local $strSymbol = _getProfileString("Symbol")
	For $i = 0 to $iMax - 1
		If $arAccountChecked[$i] == $GUI_CHECKED Then
			Local $strPassword = $arAccountPassword[$i]
			$hWnd = YinheLogin($arAccountNumber[$i], $strPassword)
			If _getProfileInt("Order") == $GUI_CHECKED Then
				YinheOrderFund($hWnd, $strSymbol)
			ElseIf _getProfileInt("Sell") == $GUI_CHECKED Then
				YinheSell($hWnd, $strSymbol, _getProfileString("SellPrice"))
			ElseIf _getProfileInt("Money") == $GUI_CHECKED Then
				YinheMoney($hWnd)
			ElseIf _getProfileInt("Cash") == $GUI_CHECKED Then
				YinheCash($hWnd, $strPassword)
			ElseIf _getProfileInt("Cancel") == $GUI_CHECKED Then
				YinheCancelAll($hWnd)
			ElseIf _getProfileInt("Login") == $GUI_CHECKED Then
				YinheInquire($hWnd, $arAccountNumber, $arAccountPassword, $arAccountChecked, $iMax, $i)
				ExitLoop
			EndIf
			YinheClose($hWnd)
		EndIf
	Next
EndFunc

	YinheMain()
