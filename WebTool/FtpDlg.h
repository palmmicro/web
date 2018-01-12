#pragma once
#include "afxwin.h"

enum EnumFtpLast {eFtpLastUpgrade, eFtpLastFile};

// CFtpDlg dialog

class CFtpDlg : public CDialog
{
	DECLARE_DYNAMIC(CFtpDlg)

public:
	CFtpDlg(CWnd* pParent = NULL);   // standard constructor
	virtual ~CFtpDlg();

// Dialog Data
	enum { IDD = IDD_FTPBOX };

protected:
	virtual void DoDataExchange(CDataExchange* pDX);    // DDX/DDV support
	virtual BOOL OnInitDialog();

	DECLARE_MESSAGE_MAP()
	afx_msg void OnBnClickedFtpBrowse();
	afx_msg void OnBnClickedFtpLastTime();
	afx_msg void OnBnClickedFtpLastFile();

protected:
	CStatic m_ctlFileName;
	CStatic m_ctlTime;
	CButton m_ctlBrowse;

public:
	int m_iLastTime;
	CString m_strTime;
	CString m_strFileName;
};
