// InsertDlg.cpp : implementation file
//

#include "stdafx.h"
#include "WebTool.h"
#include "InsertDlg.h"


// CInsertDlg dialog

IMPLEMENT_DYNAMIC(CInsertDlg, CDialog)

CInsertDlg::CInsertDlg(CWnd* pParent /*=NULL*/)
	: CDialog(CInsertDlg::IDD, pParent)
	, m_strName(_T(""))
	, m_bChinese(FALSE)
	, m_bReplace(FALSE)
	, m_bModifyBlog(FALSE)
	, m_strTitle(_T(""))
	, m_strChineseTitle(_T(""))
	, m_strImageText(_T(""))
	, m_bInsertForm(FALSE)
{

}

CInsertDlg::~CInsertDlg()
{
}

void CInsertDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
	DDX_Text(pDX, IDC_INSERT_NAME, m_strName);
	DDX_Check(pDX, IDC_INSERT_CHINESE, m_bChinese);
	DDX_Check(pDX, IDC_INSERT_REPLACE, m_bReplace);
	DDX_Check(pDX, IDC_INSERT_MODIFY_BLOG, m_bModifyBlog);
	DDX_Control(pDX, IDC_INSERT_TITLE, m_ctlTitle);
	DDX_Control(pDX, IDC_INSERT_CHINESE_TITLE, m_ctlChineseTitle);
	DDX_Text(pDX, IDC_INSERT_TITLE, m_strTitle);
	DDX_Text(pDX, IDC_INSERT_CHINESE_TITLE, m_strChineseTitle);
	DDX_Control(pDX, IDC_INSERT_MODIFY_BLOG, m_ctlModifyBlog);
	DDX_Control(pDX, IDC_INSERT_IMAGE_TEXT, m_ctlImageText);
	DDX_Text(pDX, IDC_INSERT_IMAGE_TEXT, m_strImageText);
	DDX_Control(pDX, IDC_INSERT_FORM, m_ctlInsertForm);
	DDX_Check(pDX, IDC_INSERT_FORM, m_bInsertForm);
	DDX_Control(pDX, IDC_INSERT_CHINESE, m_bInsertChinese);
}


BEGIN_MESSAGE_MAP(CInsertDlg, CDialog)
	ON_BN_CLICKED(IDC_INSERT_MODIFY_BLOG, &CInsertDlg::OnBnClickedInsertModifyBlog)
	ON_BN_CLICKED(IDC_INSERT_CHINESE, &CInsertDlg::OnBnClickedInsertChinese)
	ON_BN_CLICKED(IDC_INSERT_FORM, &CInsertDlg::OnBnClickedInsertForm)
END_MESSAGE_MAP()


// CInsertDlg message handlers

BOOL CInsertDlg::OnInitDialog()
{
	CDialog::OnInitDialog();

	// TODO:  Add extra initialization here
	m_ctlModifyBlog.EnableWindow(m_bModifyBlog);
	EnableModifyBlog();

	m_ctlInsertForm.EnableWindow(m_bInsertForm);
	OnInsertFormChanged();

	return TRUE;  // return TRUE unless you set the focus to a control
	// EXCEPTION: OCX Property Pages should return FALSE
}

void CInsertDlg::OnBnClickedInsertModifyBlog()
{
	UpdateData(TRUE);
	EnableModifyBlog();
}

void CInsertDlg::EnableModifyBlog()
{
	m_ctlChineseTitle.EnableWindow(m_bChinese && m_bModifyBlog);
	m_ctlTitle.EnableWindow(m_bModifyBlog);
	m_ctlImageText.EnableWindow(m_bModifyBlog);
}

void CInsertDlg::OnBnClickedInsertChinese()
{
	UpdateData(TRUE);
	m_ctlChineseTitle.EnableWindow(m_bChinese && m_bModifyBlog);
}

void CInsertDlg::OnInsertFormChanged()
{
	if (m_bInsertForm)
	{
		m_bChinese = FALSE;
		UpdateData(FALSE);
		m_bInsertChinese.EnableWindow(FALSE);
	}
	else
	{
		m_bInsertChinese.EnableWindow(TRUE);
	}
}

void CInsertDlg::OnBnClickedInsertForm()
{
	UpdateData(TRUE);
	OnInsertFormChanged();
}
