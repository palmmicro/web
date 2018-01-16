#include "stdafx.h"
#include "WinSCP.h"


WinSCP::WinSCP()
{
}

bool WinSCP::AddFile(CString strLocal, CString strRemote)
{
	return true;
}

bool WinSCP::UpLoad(CString strExe, CString strScript, CString strLog)
{
	CFileStatus status;
	if (CFile::GetStatus(strLog, status))
	{
		CFile::Remove(strLog);
	}

//	LPCSTR strCmd = "\"C:\\Program Files (x86)\\WinSCP\\WinSCP.exe\" /log=\"C:\\Temp\\WinSCP.log\" /ini=nul /script=\"C:\\Temp\\WinSCPscript.txt\"";
	CString strLogFile = AddDoubleQuotation(strLog);
	CString strCmd = AddDoubleQuotation(strExe) + _T(" /log=") + strLogFile + _T(" /ini=nul /script=") + AddDoubleQuotation(strScript);
	OutputDebugString(strCmd + _T("\n"));

	ExecCmd(strCmd);
	ExecCmd(_T("notepad ") + strLogFile);
	return true;
}

WinSCP::~WinSCP()
{
}

CString WinSCP::AddDoubleQuotation(CString str)
{
	return _T("\"") + str + _T("\"");
}

UINT WinSCP::ExecCmd(CString strCmd)
{
/*	USES_CONVERSION;
	LPCSTR pCmd = T2A(strCmd.GetBuffer(strCmd.GetLength()));
	return WinExec(pCmd, 1);*/

	LPTSTR pCmd = strCmd.GetBuffer(strCmd.GetLength());
	STARTUPINFO si;
	PROCESS_INFORMATION pi;

	ZeroMemory(&si, sizeof(si));
	si.cb = sizeof(si);
	ZeroMemory(&pi, sizeof(pi));

	// Start the child process. 
	if (!CreateProcess(NULL,   // No module name (use command line)
 		pCmd,        // Command line
		NULL,           // Process handle not inheritable
		NULL,           // Thread handle not inheritable
		FALSE,          // Set handle inheritance to FALSE
		0,              // No creation flags
		NULL,           // Use parent's environment block
		NULL,           // Use parent's starting directory 
		&si,            // Pointer to STARTUPINFO structure
		&pi)           // Pointer to PROCESS_INFORMATION structure
		)
	{
//		printf("CreateProcess failed (%d).\n", GetLastError());
		return GetLastError();
	}

	// Wait until child process exits.
	WaitForSingleObject(pi.hProcess, INFINITE);

	// Close process and thread handles. 
	CloseHandle(pi.hProcess);
	CloseHandle(pi.hThread);

	return 1;
}
