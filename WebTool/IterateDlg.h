#pragma once
#include "afxwin.h"
#include "afxcmn.h"

enum EnumIterateOp {eOpRemovePrev, eOpInsertPrev, eOpReplace, eOpInsertNext, eOpRemoveNext};

// CIterateDlg dialog

class CIterateDlg : public CDialog
{
	DECLARE_DYNAMIC(CIterateDlg)

public:
	CIterateDlg(CWnd* pParent = NULL);   // standard constructor
	virtual ~CIterateDlg();

// Dialog Data
	enum { IDD = IDD_ITERATEBOX };

protected:
	virtual void DoDataExchange(CDataExchange* pDX);    // DDX/DDV support
	virtual BOOL OnInitDialog();

	DECLARE_MESSAGE_MAP()
	afx_msg void OnBnClickedIterateRemovePrev();
	afx_msg void OnBnClickedIterateInsertPrev();
	afx_msg void OnBnClickedIterateReplace();
	afx_msg void OnBnClickedOk();
	afx_msg void OnBnClickedIterateReplaceMatchOnly();
	afx_msg void OnBnClickedIterateRemoveMultiLine();
	afx_msg void OnBnClickedIterateInsertMultiStr();
	afx_msg void OnBnClickedIterateBrowse();

	BOOL EnableNewStr();
	BOOL EnableReplace();
	BOOL EnableInsert();
	BOOL EnableRemove();

protected:
	CComboBox m_ctlNewStr;
	CComboBox m_ctlMatchStr;
	CButton m_ctlReplaceMatchOnly;
	CButton m_ctlReplaceAddPath;
	CButton m_ctlRemoveMultiLine;
	CButton m_ctlBrowse;
	CButton m_ctlInsertMultiStr;
	CEdit m_ctlLineNum;
	CStatic m_ctlTxtFile;
	CButton m_ctlFolderOnly;
	CButton m_ctlFolderRecursive;

public:
	CString m_strNew;
	CString m_strMatch;
	CString m_strTxtFile;
	int m_iOperation;
	BOOL m_bReplaceMatchOnly;
	BOOL m_bReplaceAddPath;
	BOOL m_bInsertMultiStr;
	BOOL m_bRemoveMultiLine;
	UINT m_iLineNum;
	BOOL m_bFolderOnly;
	BOOL m_bFolderRecursive;
	BOOL m_bFolderSelected;
	afx_msg void OnBnClickedIterateFolderRecursive();
};
