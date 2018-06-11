// WebToolDoc.h : interface of the CWebToolDoc class
//


#pragma once

class CLeftView;
class CIterateDlg;
class CInsertDlg;

class WinSCP;

class CWebToolDoc : public CDocument
{
protected: // create from serialization only
	CWebToolDoc();
	DECLARE_DYNCREATE(CWebToolDoc)

// Attributes
public:

// Operations
public:
	void OnItemSelected();
	void OnItemMoved();

// Overrides
public:
	virtual BOOL OnNewDocument();
	virtual BOOL OnOpenDocument(LPCTSTR lpszPathName);
	virtual void Serialize(CArchive& ar);

// Implementation
public:
	virtual ~CWebToolDoc();
#ifdef _DEBUG
	virtual void AssertValid() const;
	virtual void Dump(CDumpContext& dc) const;
#endif

// Generated message map functions
protected:
	DECLARE_MESSAGE_MAP()
	afx_msg void OnUpdateFileSave(CCmdUI *pCmdUI);
	afx_msg void OnFileDirectory();
	afx_msg void OnUpdateFileDirectory(CCmdUI *pCmdUI);
	afx_msg void OnToolsIterate();
	afx_msg void OnToolsUndo();
	afx_msg void OnUpdateToolsUndo(CCmdUI *pCmdUI);
	afx_msg void OnToolsOptions();
	afx_msg void OnToolsGenerateSitemap();
	afx_msg void OnToolsFtp();
	afx_msg void OnTreeDelete();
	afx_msg void OnTreeLoad();
	afx_msg void OnUpdateTreeLoad(CCmdUI *pCmdUI);
	afx_msg void OnTreeInsert();
	afx_msg void OnTreeCopy();
	afx_msg void OnUpdateTreeCopy(CCmdUI *pCmdUI);

protected:
	int m_iVersion;

	CString m_strFtpDomain;
	CString m_strFtpSubDomain;
	CString m_strFtpUserName;
	CString m_strFtpPassword;
	int m_iFtpEncryption;

	CString m_strWinscpExe;
	CString m_strWinscpScript;
	CString m_strWinscpLog;

	CStringList m_listTxtFile;
	
	int m_iTreeLevel;
	int m_iIterateFilesChanged;

	WinSCP * m_pFtp;

	int m_iFtpLastTime;
	CString m_strFtpLast;
	CTime m_timeFtpLast;
	CTime m_timeFtpCompare;


protected:
	CTreeCtrl & GetTreeCtrl();
	CLeftView * GetLeftView();

	void AddFiles(HTREEITEM hParent = TVI_ROOT);
	void AddFilesByType(HTREEITEM hParent, CStringList & list, CString strType);

	void GetItemPath(HTREEITEM hCur, CString & strPath, const TCHAR c);
	void GetItemPathName(HTREEITEM hCur, CString & strPathName);
	BOOL IsHtmlFileSelected();
	BOOL IsPhpFileSelected();
	BOOL IsFileFolderSelected();

	void StoringTree(CArchive & ar, HTREEITEM hCur);
	int LoadingTree(CArchive & ar, HTREEITEM hParent);

	void ToolsIterateItem(HTREEITEM hCur, CIterateDlg * pDlg);
	void ToolsIterateFile(CString strPathName, CIterateDlg * pDlg);
	BOOL IterateFileForward(CIterateDlg * pDlg, CStringList & list);
	BOOL IterateFileBackward(CIterateDlg * pDlg, CStringList & list);
	CString AddPath(CIterateDlg * pDlg);

	void ToolsGenerateSitemap(HTREEITEM hCur, CString strDomain, CStringList & list);
	void ToolsUndoItem(HTREEITEM hCur);
	void ToolsFtpItem(HTREEITEM hCur);
	void ToolsGB2312ToUTF8Item(HTREEITEM hCur);

	BOOL IsBlogItem(HTREEITEM hItem);
	BOOL IsFormItem(HTREEITEM hItem);

	void InsertFormFiles(CInsertDlg & dlg, CString strPathName, HTREEITEM hParent);

public:
	afx_msg void OnToolsClear();
	afx_msg void OnTreeDeleteEmpty();
	afx_msg void OnUpdateTreeDeleteEmpty(CCmdUI *pCmdUI);
	afx_msg void OnTreeLoadNonEmpty();
	afx_msg void OnUpdateTreeLoadNonEmpty(CCmdUI *pCmdUI);
	afx_msg void OnToolsGB2312ToUTF8();
	afx_msg void OnToolsAddDownload();
	afx_msg void OnToolsTouch();
	afx_msg void OnToolsAddImage();
	afx_msg void OnWinscpExe();
	afx_msg void OnWinscpScript();
	afx_msg void OnWinscpLog();
};

void GetChineseName(CString & strName, CString strType);
BOOL IsFileFolder(CString str);
BOOL IsEditFile(CString str);
BOOL IsHtmlFile(CString str);
BOOL IsPhpFile(CString str);
BOOL IsJsFile(CString str);
BOOL IsCssFile(CString str);
