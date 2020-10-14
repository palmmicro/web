'''
多行注释
'''
import win32api
import win32con
win32api.ShellExecute(0, 'open', 'C:\中国银河证券海王星独立交易\Tc.exe', '', 'C:\中国银河证券海王星独立交易', win32con.SW_SHOW)
print("Hello, world!")  #使用print输出字符串
