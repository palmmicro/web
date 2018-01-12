// WebToolView.cpp : implementation of the CWebToolView class
//

#include "stdafx.h"
#include "WebTool.h"

#include "WebToolDoc.h"
#include "WebToolView.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#endif


// CWebToolView

IMPLEMENT_DYNCREATE(CWebToolView, CHtmlView)

BEGIN_MESSAGE_MAP(CWebToolView, CHtmlView)
END_MESSAGE_MAP()

// CWebToolView construction/destruction

CWebToolView::CWebToolView()
{
	m_iCount = 0;
}

CWebToolView::~CWebToolView()
{
}

BOOL CWebToolView::PreCreateWindow(CREATESTRUCT& cs)
{
	// TODO: Modify the Window class or styles here by modifying
	//  the CREATESTRUCT cs

	return CHtmlView::PreCreateWindow(cs);
}

void CWebToolView::OnInitialUpdate()
{
	CHtmlView::OnInitialUpdate();

	CString str = AfxGetApp()->GetProfileString(_T("OptionsDlg"), _T("StartPage"), _T("http://www.palmmicro.com/woody/myphoto/2010/ushighway1_s.jpg"));

	Navigate2(str, NULL, NULL);
}


// CWebToolView diagnostics

#ifdef _DEBUG
void CWebToolView::AssertValid() const
{
	CHtmlView::AssertValid();
}

void CWebToolView::Dump(CDumpContext& dc) const
{
	CHtmlView::Dump(dc);
}

CWebToolDoc* CWebToolView::GetDocument() const // non-debug version is inline
{
	ASSERT(m_pDocument->IsKindOf(RUNTIME_CLASS(CWebToolDoc)));
	return (CWebToolDoc*)m_pDocument;
}
#endif //_DEBUG


// CWebToolView message handlers

void CWebToolView::UpdateFile(CString strFileName)
{
	Navigate2(strFileName, NULL, NULL);
	m_iCount = 0;
}

void CWebToolView::DocumentComplete(LPDISPATCH pDisp, VARIANT* URL)
{
	LPDISPATCH lpWBDisp = NULL;
    HRESULT hr = NULL;

    hr = m_pBrowserApp->QueryInterface(IID_IDispatch, (void**)&lpWBDisp);
    ASSERT(SUCCEEDED(hr));

    if (pDisp == lpWBDisp)
    {
		if (m_iCount)
		{
			GetDocument()->OnItemMoved();
		}
		else
		{
			m_iCount ++;
		}
/*
		CString str;
		str.Format(_T("DocumentComplete %d\n"), m_iCount);
		OutputDebugString(str);
*/
	}

    lpWBDisp->Release();
}
