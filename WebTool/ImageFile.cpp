#include "stdafx.h"
#include "ImageFile.h"


CImageFile::CImageFile()
{
}


CImageFile::~CImageFile()
{
}

bool CImageFile::ModifyFile(CString strFileName, CString strInsert)
{
	return InsertFile(strFileName, strInsert, _T("<h1>"));
}

bool CImageFile::Modify(CString strPathName, CString strTitle, CString strChineseTitle, CString strAltText)
{
	if (!GetFileName(strPathName))		return false;
//	if (!GetFileDate(strPathName))		return false;
	if (!GetFileNameDate())				return false;

	CString strFileName;
	CString strInsert;

	strFileName.Format(_T("woody\\sapphire\\photo%04d.php"), m_iYear);
	strInsert.Format(_T("\n<p>%s. %s. <a href=\"%04d/large/%s\" target=_blank>Large</a>\n<br /><img src=%04d/%s alt=\"%s.\" /></p>"), m_strDateNoYear, strTitle, m_iYear, m_strFileName, m_iYear, m_strFileName, strAltText);
	if (!ModifyFile(strFileName, strInsert))	return false;

	strFileName.Format(_T("woody\\sapphire\\photo%04dcn.php"), m_iYear);
	strInsert.Format(_T("\n<p>%s. %s. <a href=\"%04d/large/%s\" target=_blank>·Å´ó</a>\n<br /><img src=%04d/%s alt=\"%s.\" /></p>"), m_strChineseDateNoYear, strChineseTitle, m_iYear, m_strFileName, m_iYear, m_strFileName, strAltText);

	if (!ModifyFile(strFileName, strInsert))	return false;
	return true;
}

