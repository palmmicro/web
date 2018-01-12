#pragma once
#include "afxwin.h"


// COptionsDlg dialog

class COptionsDlg : public CDialog
{
	DECLARE_DYNAMIC(COptionsDlg)

public:
	COptionsDlg(CWnd* pParent = NULL);   // standard constructor
	virtual ~COptionsDlg();

// Dialog Data
	enum { IDD = IDD_OPTIONSBOX };

protected:
	virtual void DoDataExchange(CDataExchange* pDX);    // DDX/DDV support

	DECLARE_MESSAGE_MAP()

public:
	CString m_strFtpDomain;
	CString m_strFtpSubDomain;
	CString m_strFtpUserName;
	CString m_strFtpPassword;
	afx_msg void OnBnClickedOk();
	CString m_strStartPage;
	virtual BOOL OnInitDialog();
	CComboBox m_ctlFtpEncryption;
	int m_iFtpEncryption;
};
