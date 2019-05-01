#include "stdafx.h"
#include "MyString.h"
#include "WinSCP.h"
#include "TxtFile.h"

#define FTP_ENCRYPTION_NONE		0
#define FTP_ENCRYPTION_SSL		1

WinSCP::WinSCP()
{
	m_strPath = _T("");
	m_iTotal = 0;
}

WinSCP::~WinSCP()
{
}

void WinSCP::AddFile(CString strLocal, CString strRemote)
{
	int iPos = strLocal.ReverseFind('\\');
	CString strPath = strLocal.Left(iPos);
	CString strFileName = strLocal.Right(strLocal.GetLength() - iPos - 1);

	if (m_strPath != strPath)
	{
		m_strPath = strPath;
		m_listScript.AddTail(_T("lcd ") + strPath);

		iPos = strRemote.ReverseFind('/');
		CString strRemotePath = strRemote.Left(iPos);
		m_listScript.AddTail(_T("cd /") + strRemotePath);
	}
	m_listScript.AddTail(_T("put ") + strFileName);
	m_iTotal ++;
}

bool WinSCP::CheckLogFile(CString strLog)
{
	CTxtFile file;
	CStringList list;
	POSITION pos;
	CString str;
	int iTotal = 0;
	CString strVal;

	if (file.ReadToStringList(strLog, list))
	{
		for (pos = list.GetHeadPosition(); pos != NULL;)
		{
			str = list.GetNext(pos);
			if (str.Find(_T("Upload successful")) != -1)
			{
				iTotal ++;
			}
		}
		if (iTotal == m_iTotal)	return true;
	}
	return false;
}

int WinSCP::UpLoad(CString strExe, CString strScript, CString strLog, CString strDomain, CString strUserName, CString strPassword, int iEncryption)
{
	if (m_iTotal == 0)	return 0;

	// Clean log file
	CFileStatus status;
	if (CFile::GetStatus(strLog, status))
	{
		CFile::Remove(strLog);
	}

	// Prepare script file
	ReplaceEscapeCharacter(strUserName);
	ReplaceEscapeCharacter(strPassword);
	CString strOpenCmd;
	if (iEncryption == FTP_ENCRYPTION_SSL)
	{
		strOpenCmd = _T("open ftpes://") + strUserName + _T(":") + strPassword + _T("@") + strDomain + _T("/ -certificate=\"*\" -rawsettings ProxyPort=0");
	}
	else
	{   //	open ftp ://admin:woody3178@111.230.12.222/
//		strOpenCmd = _T("open ftp://") + strUserName + _T(":") + strPassword + _T("@") + strDomain + _T("/ -passive=0");
		strOpenCmd = _T("open ftp://") + strUserName + _T(":") + strPassword + _T("@") + strDomain;
	}
	m_listScript.AddHead(strOpenCmd);

	m_listScript.AddTail(_T("exit"));
//	DebugStringList(m_listScript);

	CTxtFile file;
	file.WriteFromStringList(strScript, m_listScript);

//	LPCSTR strCmd = "\"C:\\Program Files (x86)\\WinSCP\\WinSCP.exe\" /log=\"C:\\Temp\\WinSCP.log\" /ini=nul /script=\"C:\\Temp\\WinSCPscript.txt\"";
	CString strLogFile = AddDoubleQuotation(strLog);
	CString strCmd = AddDoubleQuotation(strExe) + _T(" /log=") + strLogFile + _T(" /ini=nul /script=") + AddDoubleQuotation(strScript);
//	DebugString(strCmd);

	ExecCmd(strCmd);
	if (CheckLogFile(strLog))
	{
		return m_iTotal;
	}
	ExecCmd(_T("notepad ") + strLogFile);
	return -1;
}


