#include "StdAfx.h"
#include "BlogFile.h"

const CString c_strJsType = _T(".js");
const CString c_strCssType = _T(".css");
const CString c_strPhpType = _T(".php");
const CString c_strPythonType = _T(".py");
const CString c_strAutoitType = _T(".au3");
const CString c_strHtmlType = _T(".html");
const CString c_strChinese = _T("cn");
const CString c_strBlogHead = _T("<tr><td class=THead>");
const CString c_strTitle = _T("<title>");

CBlogFile::CBlogFile()
{
}

CBlogFile::~CBlogFile()
{
}

bool CBlogFile::_ModifyJsFile(CString strFileName, CString strName, bool bModifyNum)
{
	int iNum, iPos;
	CStringList list;
	POSITION pos, old;
	CString str;
	CString strVal;

	if (!ReadToStringList(strFileName, list))	return false;

	pos = list.GetHeadPosition();
	if (pos == NULL)	return false;

	old = pos;
	str = list.GetNext(pos);

	// var _arPalmmicros = new Array("20061123", "20070324", "20080326", "20091114", "20100107", "20100330", "20100427", "20100909");
	iPos = str.Find(_T(");"));
	if (iPos == -1)		return false;
	str = str.Left(iPos) + _T(", \"") + m_strName + _T("\"") + str.Right(str.GetLength() - iPos);
	list.SetAt(old, str);

	if (bModifyNum)
	{
		//	var _iTotalPalmmicros = 8;
		old = pos;
		str = list.GetNext(pos);
		iPos = str.Find(_T("= "));
		if (iPos == -1)		return false;
		strVal = str.Right(str.GetLength() - iPos - 2);
		swscanf_s(strVal, _T("%d;"), &iNum);
		iNum ++;
		strVal.Format(_T("%d;"), iNum);
		str = str.Left(iPos + 2) + strVal;
		list.SetAt(old, str);
	}

	return WriteFromStringList(strFileName, list);
}

bool CBlogFile::ModifyJs(CString strName, CString strParentPath, CString strParentName)
{
	int iYear, iMon, iDay;
	CString strFileName;

	swscanf_s(strName, _T("%04d%02d%02d"), &iYear, &iMon, &iDay);
	m_strName = strName;
	m_strPhoto.Format(_T("photo%04d"), iYear);

	Generate(iYear, iMon, iDay);

	m_strParentName = strParentName;
	m_strParentPath = strParentPath;

	// \woody\blog\palmmicro\palmmicro.js
	strFileName = m_strParentPath + c_cBackSlash + m_strParentName + c_strJsType;
	if (_ModifyJsFile(strFileName, strName, true))
	{
		CFileStatus status;

		// \woody\blog\palmmicro\php\_palmmicro.php
		strFileName = m_strParentPath + c_cBackSlash + _T("php\\_") + m_strParentName + c_strPhpType;
		if (CFile::GetStatus(strFileName, status))
		{
			return _ModifyJsFile(strFileName, strName, false);
		}
		return true;
	}
	return false;
}

bool CBlogFile::Modify(CString strTitle, CString strImageText, bool bChinese)
{
	CStringList list;
	POSITION pos, old;
	CString str;
	CString strFileName;
	bool bFound;
	int iCount;

	if (bChinese)
	{
		strFileName = m_strParentPath + c_cBackSlash + m_strName + c_strChinese + c_strPhpType;
	}
	else
	{
		strFileName = m_strParentPath + c_cBackSlash + m_strName + c_strPhpType;
	}

	if (!ReadToStringList(strFileName, list))	return false;

	// process
	bFound = false;
	for (pos = list.GetHeadPosition(); pos != NULL;)
	{
		old = pos;
		str = list.GetNext(pos);
		if (bFound)
		{
			iCount --;
			if (iCount == 0)
			{
				str.Format(_T("<tr><td>%s</td></tr>"), bChinese ? m_strChineseDate : m_strDate);
				list.SetAt(old, str);
				if (HasJpgFile())
				{
					str.Format(_T("<tr><td><img src=../photo/%s.jpg alt=\"%s\" /></td></tr>"), m_strName, strImageText);
					list.InsertAfter(old, str);
				}
				break;
			}
		}
		else
		{
			if (str.Find(c_strBlogHead) != -1)
			{
				str = c_strBlogHead + strTitle + _T("</td></tr>");
				list.SetAt(old, str);
				bFound = true;
				iCount = 2;
			}
			else if (str.Left(c_strTitle.GetLength()) == c_strTitle)
			{
				str = c_strTitle + strTitle + _T("</title>");
				list.SetAt(old, str);
			}
		}
	}

	return WriteFromStringList(strFileName, list);
}

bool CBlogFile::HasJpgFile()
{
	CString strJpgName;
	CFileStatus status;

	strJpgName = m_strParentPath.Left(m_strParentPath.GetLength() - m_strParentName.GetLength()) + _T("photo\\") + m_strName + _T(".jpg");
	OutputDebugString(strJpgName + _T("\n"));
	if (CFile::GetStatus(strJpgName, status))		return true;

	return false;
}

bool CBlogFile::ModifyParent(CString strTitle, CString strImageText, bool bChinese)
{
	CString str, strFormat, strInsert1, strInsert1NoYear, strInsert2, strFileName;
	CStringList list;
	POSITION pos;

	if (bChinese)
	{
		strFileName = m_strParentPath + c_strChinese + c_strHtmlType;
		strFormat = _T("<tr><td>%s <a href=\"%s/%scn.php\">%s</a></td></tr>");
	}
	else
	{
		strFileName = m_strParentPath + c_strHtmlType;
		strFormat = _T("<tr><td>%s <a href=\"%s/%s.php\">%s</a></td></tr>");
	}
	strInsert1.Format(strFormat, (bChinese ? m_strChineseDate : m_strDate), m_strParentName, m_strName, strTitle);
	strInsert1NoYear.Format(strFormat, (bChinese ? m_strChineseDateNoYear : m_strDateNoYear), m_strParentName, m_strName, strTitle);

	if (!ReadToStringList(strFileName, list))	return false;

	// process
	for (pos = list.GetHeadPosition(); pos != NULL;)
	{
		str = list.GetNext(pos);
		if (str.Find(c_strBlogHead) != -1)
		{
			list.InsertAfter(pos, strInsert1);
			break;
		}
	}

	if (!WriteFromStringList(strFileName, list))	return false;

	if (!HasJpgFile())	return true;	// do not modify photo20xx.html if no jpg file there;

	if (!ReplaceString(strFileName, m_strParentName, m_strPhoto))	return false;
	if (!ReadToStringList(strFileName, list))	return false;

	strInsert2.Format(_T("<tr><td><img src=photo/%s.jpg alt=\"%s\" /></td></tr>"), m_strName, strImageText);
	// process
	for (pos = list.GetHeadPosition(); pos != NULL;)
	{
		str = list.GetNext(pos);
		if (str.Find(c_strBlogHead) != -1)
		{
			list.InsertAfter(pos, strInsert2);
			list.InsertAfter(pos, strInsert1NoYear);
			break;
		}
	}

	return WriteFromStringList(strFileName, list);
}

bool CBlogFile::ModifyRoot(CString strRootPath, CString strRootName, CString strTitle, bool bChinese)
{
	CString str, strFormat, strInsert, strFileName;
	CStringList list;
	POSITION old, pos;

	if (bChinese)
	{
		strFileName = strRootPath + c_strChinese + c_strHtmlType;
		strFormat = _T("<tr><td>%s <a href=\"%s/%s/%scn.php\">%s</a></td></tr>");
	}
	else
	{
		strFileName = strRootPath + c_strHtmlType;
		strFormat = _T("<tr><td>%s <a href=\"%s/%s/%s.php\">%s</a></td></tr>");
	}
	strInsert.Format(strFormat, (bChinese ? m_strChineseDate : m_strDate), strRootName, m_strParentName, m_strName, strTitle);

	if (!ReadToStringList(strFileName, list))	return false;

	// process
	for (pos = list.GetTailPosition(); pos != NULL;)
	{
		old = pos;
		str = list.GetPrev(pos);
		if (str.Find(c_strBlogHead) != -1)
		{
			list.InsertAfter(old, strInsert);
			break;
		}
	}
	return WriteFromStringList(strFileName, list);
}
