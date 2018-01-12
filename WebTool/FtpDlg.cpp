// FtpDlg.cpp : implementation file
//

#include "stdafx.h"
#include "WebTool.h"
#include "FtpDlg.h"


// CFtpDlg dialog

IMPLEMENT_DYNAMIC(CFtpDlg, CDialog)

CFtpDlg::CFtpDlg(CWnd* pParent /*=NULL*/)
	: CDialog(CFtpDlg::IDD, pParent)
	, m_strFileName(_T(""))
	, m_iLastTime(0)
	, m_strTime(_T(""))
{

}

CFtpDlg::~CFtpDlg()
{
}

void CFtpDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
	DDX_Text(pDX, IDC_FTP_FILE_NAME, m_strFileName);
	DDX_Radio(pDX, IDC_FTP_LAST_TIME, m_iLastTime);
	DDX_Text(pDX, IDC_FTP_TIME, m_strTime);
	DDX_Control(pDX, IDC_FTP_FILE_NAME, m_ctlFileName);
	DDX_Control(pDX, IDC_FTP_BROWSE, m_ctlBrowse);
	DDX_Control(pDX, IDC_FTP_TIME, m_ctlTime);
}


BEGIN_MESSAGE_MAP(CFtpDlg, CDialog)
	ON_BN_CLICKED(IDC_FTP_BROWSE, &CFtpDlg::OnBnClickedFtpBrowse)
	ON_BN_CLICKED(IDC_FTP_LAST_TIME, &CFtpDlg::OnBnClickedFtpLastTime)
	ON_BN_CLICKED(IDC_FTP_LAST_FILE, &CFtpDlg::OnBnClickedFtpLastFile)
END_MESSAGE_MAP()


// CFtpDlg message handlers

void CFtpDlg::OnBnClickedFtpBrowse()
{
	CFileDialog dlg(TRUE, _T("*.*"), _T(""), OFN_FILEMUSTEXIST|OFN_PATHMUSTEXIST, _T("All files (*.*)|*.*|"));

	UpdateData(TRUE);
	if (dlg.DoModal() != IDOK)	return;
	m_strFileName = dlg.GetPathName();
	UpdateData(FALSE);
}

void CFtpDlg::OnBnClickedFtpLastTime()
{
	m_ctlFileName.EnableWindow(FALSE);
	m_ctlBrowse.EnableWindow(FALSE);
	m_ctlTime.EnableWindow(TRUE);
}

void CFtpDlg::OnBnClickedFtpLastFile()
{
	m_ctlFileName.EnableWindow(TRUE);
	m_ctlBrowse.EnableWindow(TRUE);
	m_ctlTime.EnableWindow(FALSE);
}

BOOL CFtpDlg::OnInitDialog()
{
	CDialog::OnInitDialog();

	// TODO:  Add extra initialization here
	if (m_iLastTime == eFtpLastUpgrade)
	{
		OnBnClickedFtpLastTime();
	}
	else
	{
		OnBnClickedFtpLastFile();
	}

	return TRUE;  // return TRUE unless you set the focus to a control
	// EXCEPTION: OCX Property Pages should return FALSE
}
