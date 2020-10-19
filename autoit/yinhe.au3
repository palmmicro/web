#include <ButtonConstants.au3>
#include <EditConstants.au3>
#include <GUIConstantsEx.au3>
#include <StaticConstants.au3>
#include <WindowsConstants.au3>

#include <GuiTreeView.au3>
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

Func _getVerifyCode($hWnd, $strControl)
    $arWinPos = WinGetPos($hWnd)
	$arPos = ControlGetPos($hWnd, "", $strControl)

	$iLeft = $arWinPos[0] + $arPos[0] + $arPos[2] + 6
	$iTop = $arWinPos[1] + $arPos[1] + 1
	$iRight = $arWinPos[0] + $arWinPos[2] - 29
	$iBottom = $arWinPos[1] + $arPos[1] + $arPos[3] - 3
#cs
	_ScreenCapture_Capture("C:\temp\GDIPlus_Image2.jpg", $iLeft, $iTop, $iRight, $iBottom)

	$iBackColor = _getPixelGrayLevel($iRight, $iBottom)
	$iHorz = $iLeft
	$strCode = ""
	For $i = 0 to 3 Step 1
		$strCode = $strCode & _getVerifyDigit($iHorz, $iTop, $iBottom, $iBackColor)
	Next
#ce
	$strCode = _TesseractScreenCapture(0, "", 1, 2, $iLeft, $iTop, $iRight, $iBottom)
	Return $strCode
EndFunc

Func YinheLogin($strAcount, $strPassword)
	Run("C:\中国银河证券海王星独立交易\Tc.exe", "C:\中国银河证券海王星独立交易\")
	$hWnd = WinWaitActive("通达信网上交易", "验证码")
	ControlFocus($hWnd, "", "Edit1")
	Send($strAcount)
;	Sleep(1000)
	ControlFocus($hWnd, "", "AfxWnd421")
	Send($strPassword)
;	Sleep(1000)
	$strControl = "Edit2"
	Do
		$strVerifyCode = _getVerifyCode($hWnd, $strControl)
		If $strVerifyCode == "" Then $strVerifyCode = "1234"
;		MsgBox(0, "Debug", $strVerifyCode)

		ControlFocus($hWnd, "", $strControl)
		Send($strVerifyCode)
		Sleep(1000)
		Send("{ENTER}")
		Sleep(1000)
	Until ControlCommand($hWnd, "", "ComboBox4", "IsEnabled") == 0

#cs
	WinWaitActive("消息标题", "今日不再提示")
	Send("{ENTER}")
	MsgBox($MB_SYSTEMMODAL, "", "Pause")
#ce
	Sleep(5000)
	$hWnd = WinGetHandle("消息标题", "今日不再提示")
	If $hWnd Then
		Send("{ENTER}")
		Sleep(1000)
	EndIf

	Return WinWaitActive("通达信网上交易V6")
EndFunc

Func YinheClose($hWnd)
;	Sleep(5000)
    If WinClose($hWnd) Then
;        MsgBox($MB_SYSTEMMODAL, "", "Window closed")
    Else
        MsgBox($MB_SYSTEMMODAL + $MB_ICONERROR, "Error", "Window not Found")
    EndIf

	WinWaitActive("退出确认", "退出系统")
	Send("{ENTER}")
	Sleep(1000)
EndFunc

Func _addSymbolSpecialKey($strSymbol)
	If $strSymbol == "160416" Then
		$hDlgWnd = WinGetHandle("请选择")
		If @error Then
		Else
			Send("{ENTER}")	;深圳股票
			Sleep(1000)
		EndIf
	EndIf
EndFunc

Func _yinheAddShenzhenOrderEntry($hWnd, $strControlID, $strAccount, $strSymbol, $strAmount)
	ControlFocus($hWnd, "", "Edit1")
	Send($strSymbol)
	Sleep(1000)
	_addSymbolSpecialKey($strSymbol)
	ControlCommand($hWnd, "", $strControlID, "SelectString", $strAccount)
;	Sleep(1000)

	Do
		$strCash = ControlGetText($hWnd, "", "Static6")
	Until $strCash <> ""
	If Number($strCash, 3) < Number($strAmount, 3) Then
		MsgBox(0, $strSymbol, "资金不足")
		Return False
	EndIf

	ControlFocus($hWnd, "", "Edit2")
	Send($strAmount)
	Sleep(1000)
	Send("{ENTER}")	;确认
	Sleep(1000)
	WinWaitActive("基金风险揭示")
	Send("{SPACE}")	;我已阅读并同意签署
	Sleep(3000)

    $hDlgWnd = WinGetHandle("文件下载")
    If @error Then
	Else
		Send("{SPACE}")	;取消
		Sleep(1000)
	EndIf

	$hFileWnd = WinWaitActive("基金概要文件")
	ControlFocus($hFileWnd, "", "Button11")
	ControlClick($hFileWnd, "", "Button11")	;本人已认真阅读并确认上述内容
	Sleep(1000)
	ControlFocus($hFileWnd, "", "Button1")
	ControlClick($hFileWnd, "", "Button1")	;确认
	Sleep(1000)

	$hHintWnd = WinWaitActive("提示信息")
	ControlClick($hHintWnd, "", "Button1")
	Sleep(1000)

#cs
	ControlFocus("基金概要文件", "", "Button11")
	Send("{SPACE}") ;本人已认真阅读并确认上述内容
	Sleep(200)
	ControlFocus("基金概要文件", "", "Button1")
	Send("{SPACE}")  ;确认
	Sleep(1000)
	ControlFocus("提示信息", "", "Button1")
	Send("{SPACE}")
	Sleep(1000)
#ce

;	WinWaitActive("提示", "基金申购")
	Send("{ENTER}")
	Sleep(1000)
;	WinWaitActive("提示", "委托已提交")
	Send("{ENTER}")
	Sleep(1000)

	Return True
EndFunc

Func _isShenzhenAccount($strAccount)
	If StringInStr($strAccount, "深") == 1 Then
		$b = True
	Else
		$b = False
	EndIf
	Return $b
EndFunc

Func _yinheAddOrderEntry($hWnd, $strControlID, $strAccount, $strSymbol, $strAmount)
	If _isShenzhenAccount($strAccount) Then
		Return _yinheAddShenzhenOrderEntry($hWnd, $strControlID, $strAccount, $strSymbol, $strAmount)
;		MsgBox(0, "Account", $strAccount)
	EndIf
	Return True
EndFunc

Func _yinheClickItem($hWnd, $strLevel1, $strLevel2)
	$strControlID = "SysTreeView321"
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

	$hCtrl = ControlGetHandle($hWnd, "", $strControlID)
	$hItem = _GUICtrlTreeView_GetSelection($hCtrl)	;Get currently selected TreeView item
	_GUICtrlTreeView_ClickItem($hCtrl, $hItem)		;perform a single click
	Sleep(1000)
EndFunc

Func YinheOrderFund($hWnd, $strSymbol, $strAmount)
	_yinheClickItem($hWnd, "场内开放式基金", "基金申购")

	$iSel = 0
	$strSel = ""
	$strOldSel = ""
	$strControlID = "ComboBox2"
	Do
		ControlCommand($hWnd, "", $strControlID, "SetCurrentSelection", $iSel)
		$strOldSel = $strSel
		$strSel = ControlGetText($hWnd, "", $strControlID)
		If $strSel <> $strOldSel Then
			If _yinheAddOrderEntry($hWnd, $strControlID, $strSel, $strSymbol, $strAmount) == False Then ExitLoop
			$iSel += 1
		EndIf
	Until $strSel == $strOldSel
EndFunc

Func _yinheAddShenzhenSellEntry($hWnd, $strSymbol, $strPrice)
	ControlFocus($hWnd, "", "AfxWnd423")
	Send($strSymbol)
	Sleep(1000)
	_addSymbolSpecialKey($strSymbol)

	Do
		$strQuantity = ControlGetText($hWnd, "", "Static8")
	Until $strQuantity <> ""
	If $strQuantity <> "0" Then
		$strPriceControl = "Edit2"
		Do
			$strSuggestedPrice = ControlGetText($hWnd, "", $strPriceControl)
		Until $strSuggestedPrice <> ""
		If $strSuggestedPrice <> $strPrice Then
			ControlFocus($hWnd, "", $strPriceControl)
			Send($strPrice)
			Sleep(1000)
		EndIf

		ControlFocus($hWnd, "", "Edit5")
		Send($strQuantity)
		Sleep(1000)
		Send("{ENTER}")	;确认
		Sleep(1000)
		Send("{ENTER}")	;确认
		Sleep(1000)
		Send("{ENTER}")	;确认
		Sleep(1000)
	EndIf
EndFunc

Func _yinheAddSellEntry($hWnd, $strAccount, $strSymbol, $strPrice)
	If _isShenzhenAccount($strAccount) Then
		_yinheAddShenzhenSellEntry($hWnd, $strSymbol, $strPrice)
	EndIf
EndFunc

Func YinheSell($hWnd, $strSymbol, $strPrice)
	_yinheClickItem($hWnd, "卖出", False)
	$iSel = 0
	$strSel = ""
	$strOldSel = ""
	$strControlID = "ComboBox3"
	Do
		ControlCommand($hWnd, "", $strControlID, "SetCurrentSelection", $iSel)
		$strOldSel = $strSel
		$strSel = ControlGetText($hWnd, "", $strControlID)
		If $strSel <> $strOldSel Then
			_yinheAddSellEntry($hWnd, $strSel, $strSymbol, $strPrice)
			$iSel += 1
		EndIf
	Until $strSel == $strOldSel
EndFunc

Func _yinheAddShenzhenMoneyEntry($hWnd)
	ControlFocus($hWnd, "", "AfxWnd423")
	Send("131810")
	Sleep(1000)

	Do
		$strQuantity = ControlGetText($hWnd, "", "Static8")
	Until $strQuantity <> ""
	If $strQuantity <> "0" Then
		$strPriceControl = "Edit2"
		Do
			$strSuggestedPrice = ControlGetText($hWnd, "", $strPriceControl)
		Until $strSuggestedPrice <> ""

		$fPrice = Number($strSuggestedPrice, 3)
		$fPrice -= 0.1
		$strPrice = String($fPrice)
		ControlFocus($hWnd, "", $strPriceControl)
		Send($strPrice)
		Sleep(1000)

		ControlFocus($hWnd, "", "Edit5")
		Send($strQuantity)
		Sleep(1000)
		Send("{ENTER}")	;确认
		Sleep(1000)
		Send("{ENTER}")	;确认
		Sleep(1000)
		Send("{ENTER}")	;确认
		Sleep(1000)
	EndIf
EndFunc

Func _yinheAddMoneyEntry($hWnd, $strAccount)
	If _isShenzhenAccount($strAccount) Then
		_yinheAddShenzhenMoneyEntry($hWnd)
		Return True
	EndIf
	Return False
EndFunc

Func YinheMoney($hWnd)
	_yinheClickItem($hWnd, "卖出", False)
	$iSel = 0
	$strSel = ""
	$strOldSel = ""
	$strControlID = "ComboBox3"
	Do
		ControlCommand($hWnd, "", $strControlID, "SetCurrentSelection", $iSel)
		$strOldSel = $strSel
		$strSel = ControlGetText($hWnd, "", $strControlID)
		If $strSel <> $strOldSel Then
			If _yinheAddMoneyEntry($hWnd, $strSel)	Then ExitLoop
			$iSel += 1
		EndIf
	Until $strSel == $strOldSel
EndFunc

Func YinheCash($hWnd, $strPassword)
	_yinheClickItem($hWnd, "资金划转", "银证转账")
	ControlCommand($hWnd, "", "ComboBox2", "SetCurrentSelection", 1)
	$iCount = 0
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
		ControlFocus($hWnd, "", "Edit1")
		Send($strCash)
		Sleep(1000)
		ControlFocus($hWnd, "", "Button1")
		ControlClick($hWnd, "", "Button1")
		WinWaitActive("确认提示", "确认")
		Send("{ENTER}")
		Sleep(1000)
		Send("{ENTER}")
		Sleep(1000)
	EndIf
EndFunc

Func _hotKeyPressed()
    Switch @HotKeyPressed ; The last hotkey pressed.
        Case "{ESC}" ; String is the {ESC} hotkey.
            Exit
    EndSwitch
EndFunc

	HotKeySet("{ESC}", "_hotKeyPressed")
;	Opt("WinDetectHiddenText", 1) ;0=don't detect, 1=do detect

	$iMax = UBound($arPassword)		; get array size
	Global $arCheckboxAccount[$iMax]
	Global $arAccountChecked[$iMax]

	$Form1_1 = GUICreate("银河海王星全自动拖拉机", 316, 474, 1049, 110)
	$Group1 = GUICtrlCreateGroup("基金代码", 168, 24, 121, 113)
	$Radio160416 = GUICtrlCreateRadio("160416", 184, 56, 81, 17)
	$Radio162411 = GUICtrlCreateRadio("162411", 184, 96, 81, 17)
	GUICtrlSetState(-1, $GUI_CHECKED)
	GUICtrlCreateGroup("", -99, -99, 1, 1)
	$Group2 = GUICtrlCreateGroup("操作", 168, 160, 121, 169)
	$RadioOrder = GUICtrlCreateRadio("场内申购", 184, 256, 89, 17)
	GUICtrlSetState(-1, $GUI_CHECKED)
	$RadioSell = GUICtrlCreateRadio("卖出", 184, 288, 89, 17)
	$RadioMoney = GUICtrlCreateRadio("深市逆回购", 184, 224, 89, 17)
	$RadioCash = GUICtrlCreateRadio("转账回银行", 184, 192, 89, 17)
	GUICtrlCreateGroup("", -99, -99, 1, 1)
	$InputSellPrice = GUICtrlCreateInput("", 168, 376, 121, 21)
	GUICtrlSetState(-1, $GUI_DISABLE)
	$Label1 = GUICtrlCreateLabel("卖出价格", 168, 352, 52, 17)
	$Label2 = GUICtrlCreateLabel("客户号", 24, 24, 40, 17)
	For $i = 0 to $iMax - 1
		$arCheckboxAccount[$i] = GUICtrlCreateCheckbox($arAccount[$i], 24, 48 + $i * 24, 121, 17)
		GUICtrlSetState(-1, $GUI_CHECKED)
	Next
	$ButtonOK = GUICtrlCreateButton("确定", 168, 424, 75, 25)
	GUICtrlSetState(-1, $GUI_FOCUS)
	GUISetState(@SW_SHOW)

	$iMsg = 0
	While 1
		$iMsg = GUIGetMsg()
		Switch $iMsg
			Case $ButtonOK
				ExitLoop

			Case $RadioCash
				If GUICtrlRead($RadioOrder) == $GUI_CHECKED Then
					GUICtrlSetState($InputSellPrice, $GUI_DISABLE)
;					GUICtrlSetState($Radio160416, $GUI_INDETERMINATE)
;					GUICtrlSetState($Radio162411, $GUI_INDETERMINATE)
				EndIf

			Case $RadioMoney
				If GUICtrlRead($RadioOrder) == $GUI_CHECKED Then GUICtrlSetState($InputSellPrice, $GUI_DISABLE)

			Case $RadioOrder
				If GUICtrlRead($RadioOrder) == $GUI_CHECKED Then GUICtrlSetState($InputSellPrice, $GUI_DISABLE)

			Case $RadioSell
				If GUICtrlRead($RadioSell) == $GUI_CHECKED Then GUICtrlSetState($InputSellPrice, $GUI_ENABLE)

			Case $GUI_EVENT_CLOSE
				Exit
		EndSwitch
	WEnd

	If GUICtrlRead($Radio160416) == $GUI_CHECKED Then
		$strSymbol = "160416"
		$strAmount = "1000"
	ElseIf GUICtrlRead($Radio162411) == $GUI_CHECKED Then
		$strSymbol = "162411"
		$strAmount = "100"
	EndIf

	For $i = 0 to $iMax - 1
		$arAccountChecked[$i] = GUICtrlRead($arCheckboxAccount[$i])
	Next

	$iCashChecked = GUICtrlRead($RadioCash)
	$iMoneyChecked = GUICtrlRead($RadioMoney)
	$iOrderChecked = GUICtrlRead($RadioOrder)
	$iSellChecked = GUICtrlRead($RadioSell)
	$strPrice = GUICtrlRead($InputSellPrice)

	GUIDelete()

	For $i = 0 to $iMax - 1
		If $arAccountChecked[$i] == $GUI_CHECKED Then
			$strPassword = $arPassword[$i]
			$hWnd = YinheLogin($arAccount[$i], $strPassword)
			If $iOrderChecked == $GUI_CHECKED Then
				YinheOrderFund($hWnd, $strSymbol, $strAmount)
			ElseIf $iSellChecked == $GUI_CHECKED Then
				YinheSell($hWnd, $strSymbol, $strPrice)
			ElseIf $iMoneyChecked == $GUI_CHECKED Then
				YinheMoney($hWnd)
			ElseIf $iCashChecked == $GUI_CHECKED Then
				YinheCash($hWnd, $strPassword)
			EndIf
			YinheClose($hWnd)
		EndIf
	Next
