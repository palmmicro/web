#if !defined(AFX_DIRECTORYDLG_H__A92F5AC3_7094_11D3_8AB6_5254AB104A0B__INCLUDED_)
#define AFX_DIRECTORYDLG_H__A92F5AC3_7094_11D3_8AB6_5254AB104A0B__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000
// DirectoryDlg.h : header file
//

/////////////////////////////////////////////////////////////////////////////
// CDirectoryDlg dialog

class CDirectoryDlg : public CFileDialog
{
	DECLARE_DYNAMIC(CDirectoryDlg)

public:
	CDirectoryDlg(BOOL bOpenFileDialog = FALSE, // TRUE for FileOpen, FALSE for FileSaveAs
		LPCTSTR lpszDefExt = NULL,
		LPCTSTR lpszFileName = NULL,
		DWORD dwFlags = OFN_PATHMUSTEXIST,
		LPCTSTR lpszFilter = NULL,
		CWnd* pParentWnd = NULL);

protected:
	virtual void OnFileNameChange();

protected:
	//{{AFX_MSG(CDirectoryDlg)
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()

protected:
	CString m_strTitle;
	CWnd * m_pwndFileName;
};

//{{AFX_INSERT_LOCATION}}
// Microsoft Visual C++ will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_DIRECTORYDLG_H__A92F5AC3_7094_11D3_8AB6_5254AB104A0B__INCLUDED_)
