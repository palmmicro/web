#include "stdafx.h"
#include "WinSCP.h"


WinSCP::WinSCP()
{
}

bool WinSCP::AddFile(CString strLocal, CString strRemote)
{
	return true;
}

bool WinSCP::UpLoad()
{
//	const CString strCmd = _T("\"C:\\Program Files (x86)\\WinSCP\\WinSCP.exe\" /log=\"C:\\Temp\\WinSCP.log\" /ini=nul /script=\"C:\\Temp\\WinSCPscript.txt\"");

//	OutputDebugString(strCmd + _T("\n"));
//	system((char *)strCmd);
//	_tsystem(strCmd);
	LPCSTR strCmd = "\"C:\\Program Files (x86)\\WinSCP\\WinSCP.exe\" /log=\"C:\\Temp\\WinSCP.log\" /ini=nul /script=\"C:\\Temp\\WinSCPscript.txt\"";
	WinExec(strCmd, 1);
	return true;
}

WinSCP::~WinSCP()
{
}
