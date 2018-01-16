#include "stdafx.h"
#include "MyString.h"


MyString::MyString()
{
}


MyString::~MyString()
{
}

void MyString::DebugString(CString str)
{
	OutputDebugString(str + _T("\n"));
}

CString MyString::AddDoubleQuotation(CString str)
{
	return _T("\"") + str + _T("\"");
}

UINT MyString::ExecCmd(CString strCmd)
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

