// IterateDlg.cpp : implementation file
//

#include "stdafx.h"
#include "WebTool.h"
#include "IterateDlg.h"

const CString c_strIterateDlg = _T("IterateDlg");

// CIterateDlg dialog

IMPLEMENT_DYNAMIC(CIterateDlg, CDialog)

CIterateDlg::CIterateDlg(CWnd* pParent /*=NULL*/)
	: CDialog(CIterateDlg::IDD, pParent)
	, m_strNew(_T(""))
	, m_strMatch(_T(""))
	, m_iOperation(0)
	, m_bReplaceMatchOnly(FALSE)
	, m_bReplaceAddPath(FALSE)
	, m_bInsertMultiStr(FALSE)
	, m_iLineNum(0)
	, m_bRemoveMultiLine(FALSE)
	, m_strTxtFile(_T(""))
	, m_bFolderOnly(FALSE)
	, m_bFolderRecursive(FALSE)
{

}

CIterateDlg::~CIterateDlg()
{
}

void CIterateDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
	DDX_Text(pDX, IDC_ITERATE_NEW_STR, m_strNew);
	DDX_Text(pDX, IDC_ITERATE_MATCH_STR, m_strMatch);
	DDX_Radio(pDX, IDC_ITERATE_REMOVE_PREV, m_iOperation);
	DDX_Control(pDX, IDC_ITERATE_NEW_STR, m_ctlNewStr);
	DDX_Control(pDX, IDC_ITERATE_MATCH_STR, m_ctlMatchStr);
	DDX_Control(pDX, IDC_ITERATE_REPLACE_MATCH_ONLY, m_ctlReplaceMatchOnly);
	DDX_Check(pDX, IDC_ITERATE_REPLACE_MATCH_ONLY, m_bReplaceMatchOnly);
	DDX_Control(pDX, IDC_ITERATE_REPLACE_ADD_PATH, m_ctlReplaceAddPath);
	DDX_Check(pDX, IDC_ITERATE_REPLACE_ADD_PATH, m_bReplaceAddPath);
	DDX_Control(pDX, IDC_ITERATE_REMOVE_MULTI_LINE, m_ctlRemoveMultiLine);
	DDX_Control(pDX, IDC_ITERATE_BROWSE, m_ctlBrowse);
	DDX_Control(pDX, IDC_ITERATE_LINE_NUM, m_ctlLineNum);
	DDX_Control(pDX, IDC_ITERATE_INSERT_MULTI_STR, m_ctlInsertMultiStr);
	DDX_Control(pDX, IDC_ITERATE_TXT_FILE, m_ctlTxtFile);
	DDX_Check(pDX, IDC_ITERATE_INSERT_MULTI_STR, m_bInsertMultiStr);
	DDX_Text(pDX, IDC_ITERATE_LINE_NUM, m_iLineNum);
	DDX_Check(pDX, IDC_ITERATE_REMOVE_MULTI_LINE, m_bRemoveMultiLine);
	DDX_Text(pDX, IDC_ITERATE_TXT_FILE, m_strTxtFile);
	DDX_Control(pDX, IDC_ITERATE_FOLDER_ONLY, m_ctlFolderOnly);
	DDX_Control(pDX, IDC_ITERATE_FOLDER_RECURSIVE, m_ctlFolderRecursive);
	DDX_Check(pDX, IDC_ITERATE_FOLDER_ONLY, m_bFolderOnly);
	DDX_Check(pDX, IDC_ITERATE_FOLDER_RECURSIVE, m_bFolderRecursive);
}


BEGIN_MESSAGE_MAP(CIterateDlg, CDialog)
	ON_BN_CLICKED(IDC_ITERATE_REMOVE_PREV, &CIterateDlg::OnBnClickedIterateRemovePrev)
	ON_BN_CLICKED(IDC_ITERATE_INSERT_PREV, &CIterateDlg::OnBnClickedIterateInsertPrev)
	ON_BN_CLICKED(IDC_ITERATE_REPLACE, &CIterateDlg::OnBnClickedIterateReplace)
	ON_BN_CLICKED(IDC_ITERATE_INSERT_NEXT, &CIterateDlg::OnBnClickedIterateInsertPrev)
	ON_BN_CLICKED(IDC_ITERATE_REMOVE_NEXT, &CIterateDlg::OnBnClickedIterateRemovePrev)
	ON_BN_CLICKED(IDOK, &CIterateDlg::OnBnClickedOk)
	ON_BN_CLICKED(IDC_ITERATE_REPLACE_MATCH_ONLY, &CIterateDlg::OnBnClickedIterateReplaceMatchOnly)
	ON_BN_CLICKED(IDC_ITERATE_REMOVE_MULTI_LINE, &CIterateDlg::OnBnClickedIterateRemoveMultiLine)
	ON_BN_CLICKED(IDC_ITERATE_INSERT_MULTI_STR, &CIterateDlg::OnBnClickedIterateInsertMultiStr)
	ON_BN_CLICKED(IDC_ITERATE_BROWSE, &CIterateDlg::OnBnClickedIterateBrowse)
	ON_BN_CLICKED(IDC_ITERATE_FOLDER_RECURSIVE, &CIterateDlg::OnBnClickedIterateFolderRecursive)
END_MESSAGE_MAP()


// CIterateDlg message handlers


void CIterateDlg::OnBnClickedIterateRemovePrev()
{
	OnBnClickedIterateRemoveMultiLine();
	m_ctlNewStr.EnableWindow(FALSE);
	m_ctlReplaceMatchOnly.EnableWindow(FALSE);
	m_ctlReplaceAddPath.EnableWindow(FALSE);
	m_ctlRemoveMultiLine.EnableWindow(TRUE);
	m_ctlInsertMultiStr.EnableWindow(FALSE);
	m_ctlBrowse.EnableWindow(FALSE);
	m_ctlTxtFile.EnableWindow(FALSE);
}

void CIterateDlg::OnBnClickedIterateInsertPrev()
{
	OnBnClickedIterateInsertMultiStr();
	m_ctlReplaceMatchOnly.EnableWindow(FALSE);
	m_ctlRemoveMultiLine.EnableWindow(FALSE);
	m_ctlLineNum.EnableWindow(FALSE);
	m_ctlInsertMultiStr.EnableWindow(TRUE);
}

void CIterateDlg::OnBnClickedIterateReplace()
{
	OnBnClickedIterateReplaceMatchOnly();
	m_ctlNewStr.EnableWindow(TRUE);
	m_ctlReplaceMatchOnly.EnableWindow(TRUE);
	m_ctlRemoveMultiLine.EnableWindow(FALSE);
	m_ctlLineNum.EnableWindow(FALSE);
	m_ctlInsertMultiStr.EnableWindow(FALSE);
	m_ctlBrowse.EnableWindow(FALSE);
	m_ctlTxtFile.EnableWindow(FALSE);
}

void CIterateDlg::OnBnClickedIterateReplaceMatchOnly()
{
	UpdateData(TRUE);
	m_ctlReplaceAddPath.EnableWindow(m_bReplaceMatchOnly && m_bFolderRecursive);
}

void CIterateDlg::OnBnClickedIterateRemoveMultiLine()
{
	UpdateData(TRUE);
	m_ctlLineNum.EnableWindow(m_bRemoveMultiLine);
}

void CIterateDlg::OnBnClickedIterateInsertMultiStr()
{
	UpdateData(TRUE);
	m_ctlBrowse.EnableWindow(m_bInsertMultiStr);
	m_ctlTxtFile.EnableWindow(m_bInsertMultiStr);
	m_ctlNewStr.EnableWindow(!m_bInsertMultiStr);
	m_ctlReplaceAddPath.EnableWindow((!m_bInsertMultiStr) && m_bFolderRecursive);
}

void CIterateDlg::OnBnClickedIterateFolderRecursive()
{
	UpdateData(TRUE);
	m_ctlReplaceAddPath.EnableWindow(EnableNewStr() && m_bFolderRecursive);
	if (!m_bFolderRecursive)
	{
		m_bReplaceAddPath = FALSE;
		UpdateData(FALSE);
	}
}

BOOL CIterateDlg::OnInitDialog()
{
	int i, iCount;
	CString str, strEntry;

	CDialog::OnInitDialog();

	// TODO:  Add extra initialization here
	m_strNew = AfxGetApp()->GetProfileString(c_strIterateDlg, _T("NewString"), _T("<tr><td>&nbsp;</td><td>&nbsp;</td></tr>"));
	m_strMatch = AfxGetApp()->GetProfileString(c_strIterateDlg, _T("MatchString"), _T("&copy;"));
	m_strTxtFile = AfxGetApp()->GetProfileString(c_strIterateDlg, _T("TxtFile"), _T(""));
	m_iOperation = AfxGetApp()->GetProfileInt(c_strIterateDlg, _T("Operation"), 2);
	m_bReplaceMatchOnly = AfxGetApp()->GetProfileInt(c_strIterateDlg, _T("ReplaceMatchOnly"), 0) ? TRUE : FALSE;
	m_bReplaceAddPath = AfxGetApp()->GetProfileInt(c_strIterateDlg, _T("ReplaceAddPath"), 0) ? TRUE : FALSE;
	m_bInsertMultiStr = AfxGetApp()->GetProfileInt(c_strIterateDlg, _T("InsertMultiStr"), 0) ? TRUE : FALSE;
	m_bRemoveMultiLine = AfxGetApp()->GetProfileInt(c_strIterateDlg, _T("RemoveMultiLine"), 0) ? TRUE : FALSE;
	m_iLineNum = AfxGetApp()->GetProfileInt(c_strIterateDlg, _T("LineNum"), 2);
	m_bFolderOnly = AfxGetApp()->GetProfileInt(c_strIterateDlg, _T("FolderOnly"), 0) ? TRUE : FALSE;
	m_bFolderRecursive = AfxGetApp()->GetProfileInt(c_strIterateDlg, _T("FolderRecursive"), 0) ? TRUE : FALSE;

	iCount = AfxGetApp()->GetProfileInt(c_strIterateDlg, _T("NewStringList"), 0);
	if (iCount)
	{
		for (i = 0; i < iCount; i ++)
		{
			strEntry.Format(_T("%s%d"), _T("NewStringList"), i);
			str = AfxGetApp()->GetProfileString(c_strIterateDlg, strEntry, _T(""));
			if (!str.IsEmpty() && m_ctlNewStr.FindStringExact(0, str) == CB_ERR)
			{
				m_ctlNewStr.AddString(str);
			}
		}
	}
	
	iCount = AfxGetApp()->GetProfileInt(c_strIterateDlg, _T("MatchStringList"), 0);
	if (iCount)
	{
		for (i = 0; i < iCount; i ++)
		{
			strEntry.Format(_T("%s%d"), _T("MatchStringList"), i);
			str = AfxGetApp()->GetProfileString(c_strIterateDlg, strEntry, _T(""));
			if (!str.IsEmpty() && m_ctlMatchStr.FindStringExact(0, str) == CB_ERR)
			{
				m_ctlMatchStr.AddString(str);
			}
		}
	}

	m_ctlNewStr.EnableWindow(EnableNewStr());
	m_ctlReplaceMatchOnly.EnableWindow(EnableReplace());
	m_ctlReplaceAddPath.EnableWindow(EnableNewStr() && m_bFolderRecursive);
	m_ctlRemoveMultiLine.EnableWindow(EnableRemove());
	m_ctlLineNum.EnableWindow(EnableRemove() && m_bRemoveMultiLine);
	m_ctlInsertMultiStr.EnableWindow(EnableInsert());
	m_ctlBrowse.EnableWindow(EnableInsert() && m_bInsertMultiStr);
	m_ctlTxtFile.EnableWindow(EnableInsert() && m_bInsertMultiStr);
	if (m_bFolderSelected)
	{
		m_ctlFolderOnly.EnableWindow(TRUE);
		m_ctlFolderRecursive.EnableWindow(TRUE);
	}
	else
	{
		m_bFolderOnly = FALSE;
		m_bFolderRecursive = TRUE;
		m_ctlFolderOnly.EnableWindow(FALSE);
		m_ctlFolderRecursive.EnableWindow(FALSE);
	}

	UpdateData(FALSE);
	return TRUE;  // return TRUE unless you set the focus to a control
	// EXCEPTION: OCX Property Pages should return FALSE
}

void CIterateDlg::OnBnClickedOk()
{
	int i, iCount;
	CString strEntry;
	CString str;

	OnOK();

	// TODO: Add your control notification handler code here
	AfxGetApp()->WriteProfileString(c_strIterateDlg, _T("NewString"), m_strNew);
	AfxGetApp()->WriteProfileString(c_strIterateDlg, _T("MatchString"), m_strMatch);
	AfxGetApp()->WriteProfileString(c_strIterateDlg, _T("TxtFile"), m_strTxtFile);
	AfxGetApp()->WriteProfileInt(c_strIterateDlg, _T("Operation"), m_iOperation);
	AfxGetApp()->WriteProfileInt(c_strIterateDlg, _T("ReplaceMatchOnly"), m_bReplaceMatchOnly ? 1: 0);
	AfxGetApp()->WriteProfileInt(c_strIterateDlg, _T("ReplaceAddPath"), m_bReplaceAddPath ? 1: 0);
	AfxGetApp()->WriteProfileInt(c_strIterateDlg, _T("InsertMultiStr"), m_bInsertMultiStr ? 1: 0);
	AfxGetApp()->WriteProfileInt(c_strIterateDlg, _T("RemoveMultiLine"), m_bRemoveMultiLine ? 1: 0);
	AfxGetApp()->WriteProfileInt(c_strIterateDlg, _T("LineNum"), m_iLineNum);
	AfxGetApp()->WriteProfileInt(c_strIterateDlg, _T("FolderOnly"), m_bFolderOnly ? 1: 0);
	AfxGetApp()->WriteProfileInt(c_strIterateDlg, _T("FolderRecursive"), m_bFolderRecursive ? 1: 0);

	if (m_ctlMatchStr.FindStringExact(0, m_strMatch) == CB_ERR)
	{
		m_ctlMatchStr.AddString(m_strMatch);
	}
	iCount = m_ctlMatchStr.GetCount();
	AfxGetApp()->WriteProfileInt(c_strIterateDlg, _T("MatchStringList"), iCount);
	if (iCount)
	{
		for (i = 0; i < iCount; i ++)
		{
			m_ctlMatchStr.GetLBText(i, str);
			strEntry.Format(_T("%s%d"), _T("MatchStringList"), i);
			AfxGetApp()->WriteProfileString(c_strIterateDlg, strEntry, str);
		}
	}

	if (EnableNewStr())
	{
		if (m_ctlNewStr.FindStringExact(0, m_strNew) == CB_ERR)
		{
			m_ctlNewStr.AddString(m_strNew);
		}
		iCount = m_ctlNewStr.GetCount();
		AfxGetApp()->WriteProfileInt(c_strIterateDlg, _T("NewStringList"), iCount);
		if (iCount)
		{
			for (i = 0; i < iCount; i ++)
			{
				m_ctlNewStr.GetLBText(i, str);
				strEntry.Format(_T("%s%d"), _T("NewStringList"), i);
				AfxGetApp()->WriteProfileString(c_strIterateDlg, strEntry, str);
			}
		}
	}
}

BOOL CIterateDlg::EnableNewStr()
{
	return (EnableReplace() || (EnableInsert() && !m_bInsertMultiStr)) ? TRUE : FALSE;
}

BOOL CIterateDlg::EnableReplace()
{
	return (m_iOperation == eOpReplace) ? TRUE : FALSE;
}

BOOL CIterateDlg::EnableInsert()
{
	return (m_iOperation == eOpInsertPrev || m_iOperation == eOpInsertNext) ? TRUE : FALSE;
}

BOOL CIterateDlg::EnableRemove()
{
	return (m_iOperation == eOpRemovePrev || m_iOperation == eOpRemoveNext) ? TRUE : FALSE;
}


void CIterateDlg::OnBnClickedIterateBrowse()
{
	CFileDialog dlg(TRUE, _T("*.txt"), _T(""), OFN_FILEMUSTEXIST|OFN_PATHMUSTEXIST, _T("Text files (*.txt)|*.txt|"));

	UpdateData(TRUE);
	if (dlg.DoModal() != IDOK)	return;
	m_strTxtFile = dlg.GetPathName();
	UpdateData(FALSE);
}

