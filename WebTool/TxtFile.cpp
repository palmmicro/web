#include "StdAfx.h"

#include <locale.h>

#include "TxtFile.h"

const TCHAR c_cNewLine = _T('\n');
const TCHAR c_cBackSlash = _T('\\');

CString _GetPath(CString strPathName)
{
	int iPos = strPathName.ReverseFind(c_cBackSlash);
	return strPathName.Left(iPos);
}

CString _GetFileName(CString strPathName)
{
	int iPos = strPathName.ReverseFind(c_cBackSlash);
	return strPathName.Right(strPathName.GetLength() - iPos - 1);
}


CTxtFile::CTxtFile()
{
}

CTxtFile::~CTxtFile()
{
}

bool CTxtFile::ReadGB2312ToStringList(CString strFileName, CStringList & list)
{
	CString str;

	// read file
	if (!Open(strFileName, CFile::modeRead|CFile::typeText))
	{
		AfxMessageBox(_T("Can not read file ") + strFileName, MB_OK | MB_ICONSTOP);
		return false;
	}

	char * old_locale = _strdup(setlocale(LC_CTYPE,NULL));
	setlocale(LC_CTYPE, "chs");

	while (CStdioFile::ReadString(str))
	{
		list.AddTail(str);
	}

	setlocale(LC_CTYPE, old_locale);
	free(old_locale); 

	Close();
	return true;
}

bool CTxtFile::ReadToStringList(CString strFileName, CStringList & list)
{
	CString str;

	SetCodePage(CP_UTF8);

	// read file
	if (!Open(strFileName, CFile::modeRead|CFile::typeText))
	{
		AfxMessageBox(_T("Can not read file ") + strFileName, MB_OK | MB_ICONSTOP);
		return false;
	}

	while (ReadString(str))
	{
		list.AddTail(str);
	}

	Close();
	return true;
}

bool CTxtFile::WriteGB2312FromStringList(CString strFileName, CStringList & list)
{
	CString str;

	// write file
	if (!Open(strFileName, CFile::modeCreate|CFile::modeWrite|CFile::typeText))
	{
		AfxMessageBox(_T("Can not write file ") + strFileName, MB_OK | MB_ICONSTOP);
		return false;
	}

	char * old_locale = _strdup(setlocale(LC_CTYPE,NULL));
	setlocale(LC_CTYPE, "chs");

	while (!list.IsEmpty())
	{
		str = list.RemoveHead();
		str += c_cNewLine;
		CStdioFile::WriteString(str);
	}

	setlocale(LC_CTYPE, old_locale);
	free(old_locale); 

	Close();
	return true;
}

#define UTF8_BUF_SIZE	5000
char g_pcUTF8[UTF8_BUF_SIZE];
unsigned char g_pcUTF8_Head[3] = {0xEF, 0xBB, 0xBF};

bool CTxtFile::WriteFromStringList(CString strFileName, CStringList & list)
{
	CString str;
	int iLen;

	// write file
	if (!Open(strFileName, CFile::modeCreate|CFile::modeWrite))
	{
		AfxMessageBox(_T("Can not write file ") + strFileName, MB_OK | MB_ICONSTOP);
		return false;
	}

//	Write(g_pcUTF8_Head, 3); 

	while (!list.IsEmpty())
	{
		str = list.RemoveHead();
		str += c_cNewLine;
		iLen = WideCharToMultiByte(CP_UTF8, 0, str, -1, g_pcUTF8, UTF8_BUF_SIZE, NULL, NULL);
		Write(g_pcUTF8, iLen - 1); 
	}

	Close();
	return true;
}

BOOL ReplaceString(CString & str, CString strOld, CString strNew)
{
	int iFind;

	iFind = str.Find(strOld);
	if (iFind != -1)
	{
		str = str.Left(iFind) + strNew + str.Right(str.GetLength() - strOld.GetLength() - iFind);
		return TRUE;
	}
	return FALSE;
}

bool CTxtFile::CopyAndReplaceFile(CString strFileName, CString strOld, CString strNew, BOOL bReplace)
{
	CStringList list;
	POSITION pos, old;
	CString str;

	if (!ReadToStringList(strFileName, list))	return false;

	// process
	if (bReplace)
	{
		for (pos = list.GetHeadPosition(); pos != NULL;)
		{
			old = pos;
			str = list.GetNext(pos);
			if (ReplaceString(str, strOld, strNew))
			{
				list.SetAt(old, str);
			}
		}
	}

	if (!ReplaceString(strFileName, strOld, strNew))
	{
		AfxMessageBox(_T("Do not know how to copy file ") + strFileName, MB_OK | MB_ICONSTOP);
		return false;
	}

	return WriteFromStringList(strFileName, list);
}

bool CTxtFile::GB2312ToUTF8(CString strFileName)
{
	CStringList list;

	if (!ReadGB2312ToStringList(strFileName, list))	return false;
	return WriteFromStringList(strFileName, list);
}

