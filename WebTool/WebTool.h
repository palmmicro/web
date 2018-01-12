// WebTool.h : main header file for the WebTool application
//
#pragma once

#ifndef __AFXWIN_H__
	#error "include 'stdafx.h' before including this file for PCH"
#endif

#include "resource.h"       // main symbols


// CWebToolApp:
// See WebTool.cpp for the implementation of this class
//

class CWebToolApp : public CWinApp
{
public:
	CWebToolApp();

// Overrides
public:
	virtual BOOL InitInstance();

// Implementation
	afx_msg void OnAppAbout();
	DECLARE_MESSAGE_MAP()
};

extern CWebToolApp theApp;