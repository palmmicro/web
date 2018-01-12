#pragma once
#include "afxwin.h"


// CInsertDlg dialog

class CInsertDlg : public CDialog
{
	DECLARE_DYNAMIC(CInsertDlg)

public:
	CInsertDlg(CWnd* pParent = NULL);   // standard constructor
	virtual ~CInsertDlg();

// Dialog Data
	enum { IDD = IDD_INSERTBOX };

protected:
	virtual void DoDataExchange(CDataExchange* pDX);    // DDX/DDV support
	virtual BOOL OnInitDialog();

	DECLARE_MESSAGE_MAP()

protected:
	CEdit m_ctlChineseTitle;
	CEdit m_ctlTitle;
	CEdit m_ctlImageText;
	CButton m_bInsertChinese;
	CButton m_ctlModifyBlog;
	CButton m_ctlInsertForm;

public:
	CString m_strName;
	CString m_strTitle;
	CString m_strChineseTitle;
	CString m_strImageText;
	BOOL m_bChinese;
	BOOL m_bReplace;
	BOOL m_bModifyBlog;
	BOOL m_bInsertForm;

protected:
	void EnableModifyBlog();
	void OnInsertFormChanged();

public:
	afx_msg void OnBnClickedInsertChinese();
	afx_msg void OnBnClickedInsertModifyBlog();
	afx_msg void OnBnClickedInsertForm();
};
