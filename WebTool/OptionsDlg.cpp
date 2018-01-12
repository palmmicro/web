// OptionsDlg.cpp : implementation file
//

#include "stdafx.h"
#include "WebTool.h"
#include "OptionsDlg.h"

const CString c_strOptionsDlg = _T("OptionsDlg");

// COptionsDlg dialog

IMPLEMENT_DYNAMIC(COptionsDlg, CDialog)

COptionsDlg::COptionsDlg(CWnd* pParent /*=NULL*/)
	: CDialog(COptionsDlg::IDD, pParent)
	, m_strFtpDomain(_T(""))
	, m_strFtpSubDomain(_T(""))
	, m_strFtpUserName(_T(""))
	, m_strFtpPassword(_T(""))
	, m_strStartPage(_T(""))
	, m_iFtpEncryption(0)
{

}

COptionsDlg::~COptionsDlg()
{
}

void COptionsDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
	DDX_Text(pDX, IDC_OPTIONS_FTP_DOMAIN, m_strFtpDomain);
	DDX_Text(pDX, IDC_OPTIONS_FTP_SUBDOMAIN, m_strFtpSubDomain);
	DDX_Text(pDX, IDC_OPTIONS_FTP_USERNAME, m_strFtpUserName);
	DDX_Text(pDX, IDC_OPTIONS_FTP_PASSWORD, m_strFtpPassword);
	DDX_Text(pDX, IDC_OPTIONS_START_PAGE, m_strStartPage);
	DDX_Control(pDX, IDC_OPTIONS_FTP_ENCRYPTION, m_ctlFtpEncryption);
	DDX_CBIndex(pDX, IDC_OPTIONS_FTP_ENCRYPTION, m_iFtpEncryption);
}


BEGIN_MESSAGE_MAP(COptionsDlg, CDialog)
	ON_BN_CLICKED(IDOK, &COptionsDlg::OnBnClickedOk)
END_MESSAGE_MAP()


// COptionsDlg message handlers

void COptionsDlg::OnBnClickedOk()
{
	// TODO: Add your control notification handler code here
	OnOK();

	AfxGetApp()->WriteProfileString(c_strOptionsDlg, _T("StartPage"), m_strStartPage);
}

BOOL COptionsDlg::OnInitDialog()
{
	CDialog::OnInitDialog();

	// TODO:  Add extra initialization here
	m_strStartPage = AfxGetApp()->GetProfileString(c_strOptionsDlg, _T("StartPage"), _T("http://www.palmmicro.com/woody/myphoto/2010/ushighway1_s.jpg"));
	m_ctlFtpEncryption.AddString(_T("Normal"));
	m_ctlFtpEncryption.AddString(_T("Require explicit FTP over TLS"));
	UpdateData(FALSE);

	return TRUE;  // return TRUE unless you set the focus to a control
	// EXCEPTION: OCX Property Pages should return FALSE
}

