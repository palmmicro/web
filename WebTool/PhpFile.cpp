#include "stdafx.h"
#include "PhpFile.h"


CPhpFile::CPhpFile()
{
}


CPhpFile::~CPhpFile()
{
}

bool CPhpFile::GetFileName(CString strPathName)
{
	m_strFileName = _GetFileName(strPathName);
	OutputDebugString(m_strFileName + _T("\n"));
	return true;
}

bool CPhpFile::GetFileDate(CString strPathName)
{
	CFileStatus status;

	if (!CFile::GetStatus(strPathName, status))		return false;

	Generate(status.m_ctime.GetYear(), status.m_ctime.GetMonth(), status.m_ctime.GetDay());

	OutputDebugString(m_strDate + _T("\n"));
	return true;
}

bool CPhpFile::GetFileNameDate()
{
	int iYear, iMon, iDay;

	swscanf_s(m_strFileName, _T("%04d%02d%02d"), &iYear, &iMon, &iDay);
	Generate(iYear, iMon, iDay);

	OutputDebugString(m_strDate + _T("\n"));
	return true;
}

bool CPhpFile::InsertFile(CString strFileName, CString strInsert, CString strFind)
{
	CStringList list;
	POSITION pos, old;
	CString str;

	if (!ReadToStringList(strFileName, list))	return false;

	// process
	for (pos = list.GetTailPosition(); pos != NULL;)
	{
		old = pos;
		str = list.GetPrev(pos);
		if (str.Find(strFind) != -1)
		{
			list.InsertAfter(old, strInsert);
			break;
		}
	}

	return WriteFromStringList(strFileName, list);
}

