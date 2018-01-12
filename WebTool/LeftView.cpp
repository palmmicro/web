// LeftView.cpp : implementation of the CLeftView class
//

#include "stdafx.h"
#include "WebTool.h"

#include "WebToolDoc.h"
#include "LeftView.h"

#include "MainFrm.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#endif

// CLeftView

IMPLEMENT_DYNCREATE(CLeftView, CTreeView)

BEGIN_MESSAGE_MAP(CLeftView, CTreeView)
	ON_WM_LBUTTONDOWN()
	ON_WM_RBUTTONDOWN()
	ON_WM_CONTEXTMENU()
	ON_NOTIFY_REFLECT(TVN_SELCHANGED, &CLeftView::OnTvnSelchanged)
END_MESSAGE_MAP()


// CLeftView construction/destruction

CLeftView::CLeftView()
{
	// TODO: add construction code here
}

CLeftView::~CLeftView()
{
}

BOOL CLeftView::PreCreateWindow(CREATESTRUCT& cs)
{
	// TODO: Modify the Window class or styles here by modifying the CREATESTRUCT cs

	return CTreeView::PreCreateWindow(cs);
}

void CLeftView::OnInitialUpdate()
{
	CTreeView::OnInitialUpdate();

	// TODO: You may populate your TreeView with items by directly accessing
	//  its tree control through a call to GetTreeCtrl().
}


// CLeftView diagnostics

#ifdef _DEBUG
void CLeftView::AssertValid() const
{
	CTreeView::AssertValid();
}

void CLeftView::Dump(CDumpContext& dc) const
{
	CTreeView::Dump(dc);
}

CWebToolDoc* CLeftView::GetDocument() // non-debug version is inline
{
	ASSERT(m_pDocument->IsKindOf(RUNTIME_CLASS(CWebToolDoc)));
	return (CWebToolDoc*)m_pDocument;
}
#endif //_DEBUG


// CLeftView message handlers

void CLeftView::OnLButtonDown(UINT nFlags, CPoint point)
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	UINT iFlags;
	HTREEITEM hItem = ctrl.HitTest(point, &iFlags);

	if ((hItem != NULL) && (iFlags & TVHT_ONITEM))
	{
		ctrl.Select(hItem, TVGN_CARET);
	}

	CTreeView::OnLButtonDown(nFlags, point);
}



void CLeftView::OnRButtonDown(UINT nFlags, CPoint point)
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	UINT iFlags;
	HTREEITEM hItem = ctrl.HitTest(point, &iFlags);

	if ((hItem != NULL) && (iFlags & TVHT_ONITEM)) 
	{
		ctrl.Select(hItem, TVGN_CARET);
	}

//	CTreeView::OnRButtonDown(nFlags, point);
}

void CLeftView::OnContextMenu(CWnd* pWnd, CPoint point)
{
	UINT iFlags;
	CTreeCtrl & ctrl = GetTreeCtrl();
	CPoint ptTree = point;
	ctrl.ScreenToClient(&ptTree);
	HTREEITEM hItem = ctrl.HitTest(ptTree, &iFlags);

	if ((hItem != NULL) && (iFlags & TVHT_ONITEM)) 
	{
		ShowPopupMenu(point);
	}
	else
	{
		CTreeView::OnContextMenu(pWnd, point);
	}
}

void CLeftView::ShowPopupMenu(CPoint& point)
{
	CMenu menu;
	VERIFY(menu.LoadMenu(IDR_LEFTVIEW));

	CMenu * pPopup = menu.GetSubMenu(0);
	ASSERT(pPopup != NULL);
	CWnd * pWndPopupOwner = this;

	while (pWndPopupOwner->GetStyle() & WS_CHILD)
	{
		pWndPopupOwner = pWndPopupOwner->GetParent();
	}
	pPopup->TrackPopupMenu(TPM_LEFTALIGN | TPM_RIGHTBUTTON, point.x, point.y, pWndPopupOwner);
}

void CLeftView::OnTvnSelchanged(NMHDR *pNMHDR, LRESULT *pResult)
{
	LPNMTREEVIEW pNMTreeView = reinterpret_cast<LPNMTREEVIEW>(pNMHDR);

	GetDocument()->OnItemSelected();
	// TODO: Add your control notification handler code here
	*pResult = 0;
}
