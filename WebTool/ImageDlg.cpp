// ImageDlg.cpp : implementation file
//

#include "stdafx.h"
#include "WebTool.h"
#include "ImageDlg.h"
#include "afxdialogex.h"


// CImageDlg dialog

IMPLEMENT_DYNAMIC(CImageDlg, CDialog)

CImageDlg::CImageDlg(CWnd* pParent /*=NULL*/)
	: CDialog(CImageDlg::IDD, pParent)
	, m_strFileName(_T("File Name:"))
	, m_strAltText(_T(""))
	, m_strChineseTitle(_T(""))
	, m_strTitle(_T(""))
{

}

CImageDlg::~CImageDlg()
{
}

void CImageDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
	DDX_Text(pDX, IDC_IMAGE_FILE_NAME, m_strFileName);
	DDX_Text(pDX, IDC_IMAGE_ALT_TEXT, m_strAltText);
	DDX_Text(pDX, IDC_IMAGE_CHINESE_TITLE, m_strChineseTitle);
	DDX_Text(pDX, IDC_IMAGE_TITLE, m_strTitle);
}


BEGIN_MESSAGE_MAP(CImageDlg, CDialog)
	ON_BN_CLICKED(IDC_IMAGE_BROWSE, &CImageDlg::OnClickedImageBrowse)
END_MESSAGE_MAP()


// CImageDlg message handlers


void CImageDlg::OnClickedImageBrowse()
{
	CFileDialog dlg(TRUE, _T("*.jpg"), _T(""), OFN_FILEMUSTEXIST | OFN_PATHMUSTEXIST, _T("Image files (*.jpg)|*.jpg|"));

	UpdateData(TRUE);
	if (dlg.DoModal() != IDOK)	return;
	m_strFileName = dlg.GetPathName();
	UpdateData(FALSE);
}
