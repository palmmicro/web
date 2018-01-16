#include "stdafx.h"
#include "MyString.h"
#include "WinSCP.h"


WinSCP::WinSCP()
{
	m_strPath = _T("");
}

bool WinSCP::AddFile(CString strLocal, CString strRemote)
{
	CString str;
	int iPos = strLocal.ReverseFind('\\');
	CString strPath = strLocal.Left(iPos);
	CString strFileName = strLocal.Right(strLocal.GetLength() - iPos - 1);
//	DebugString(strLocal);
//	DebugString(strPath);
//	DebugString(strFileName);
//	DebugString(strRemote);
	if (m_strPath != strPath)
	{
		m_strPath = strPath;
		str = _T("lcd ") + strPath;
		DebugString(str);
		m_listScript.AddTail(str);

		int iPos = strRemote.ReverseFind('/');
		CString strRemotePath = strRemote.Left(iPos);
	//	DebugString(strRemotePath);

		str = _T("cd /") + strRemotePath;
		DebugString(str);
		m_listScript.AddTail(str);
	}

	str = _T("put ") + strFileName;
	DebugString(str);
	m_listScript.AddTail(str);

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
//	DebugString(strCmd);

	ExecCmd(strCmd);
	ExecCmd(_T("notepad ") + strLogFile);
	return true;
}

WinSCP::~WinSCP()
{
}

