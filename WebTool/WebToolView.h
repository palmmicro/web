// WebToolView.h : interface of the CWebToolView class
//


#pragma once


class CWebToolView : public CHtmlView
{
protected: // create from serialization only
	CWebToolView();
	DECLARE_DYNCREATE(CWebToolView)

// Attributes
public:
	CWebToolDoc* GetDocument() const;

// Operations
public:
	void UpdateFile(CString strFileName);

// Overrides
public:
	virtual BOOL PreCreateWindow(CREATESTRUCT& cs);
	void DocumentComplete(LPDISPATCH pDisp, VARIANT* URL);
protected:
	virtual void OnInitialUpdate(); // called first time after construct

// Implementation
public:
	virtual ~CWebToolView();
#ifdef _DEBUG
	virtual void AssertValid() const;
	virtual void Dump(CDumpContext& dc) const;
#endif

protected:
	int m_iCount;

// Generated message map functions
protected:
	DECLARE_MESSAGE_MAP()
};

#ifndef _DEBUG  // debug version in WebToolView.cpp
inline CWebToolDoc* CWebToolView::GetDocument() const
   { return reinterpret_cast<CWebToolDoc*>(m_pDocument); }
#endif

