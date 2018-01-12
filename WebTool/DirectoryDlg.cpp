// DirectoryDlg.cpp : implementation file
//

#include "stdafx.h"
#include "DirectoryDlg.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif

/////////////////////////////////////////////////////////////////////////////
// CDirectoryDlg

IMPLEMENT_DYNAMIC(CDirectoryDlg, CFileDialog)

CDirectoryDlg::CDirectoryDlg(BOOL bOpenFileDialog, LPCTSTR lpszDefExt, LPCTSTR lpszFileName,
		DWORD dwFlags, LPCTSTR lpszFilter, CWnd* pParentWnd) :
		CFileDialog(bOpenFileDialog, lpszDefExt, lpszFileName, dwFlags, lpszFilter, pParentWnd)
{
	m_strTitle = _T("Select a Directory"); 
	m_ofn.lpstrTitle = m_strTitle.GetBuffer();
	m_pwndFileName = NULL;
}

BEGIN_MESSAGE_MAP(CDirectoryDlg, CFileDialog)
	//{{AFX_MSG_MAP(CDirectoryDlg)
	//}}AFX_MSG_MAP
END_MESSAGE_MAP()

void CDirectoryDlg::OnFileNameChange()
{
	if (m_pwndFileName == NULL)
	{
		m_pwndFileName = GetFocus();
		m_pwndFileName->EnableWindow(FALSE);
	}
	m_pwndFileName->SetWindowText(_T("All selected files"));
}

