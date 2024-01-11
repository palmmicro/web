// WebToolDoc.cpp : implementation of the CWebToolDoc class
//

#include "stdafx.h"
#include "WebTool.h"

#include "WebToolDoc.h"
#include "LeftView.h"

#include "MainFrm.h"

#include "DirectoryDlg.h"
#include "IterateDlg.h"
#include "OptionsDlg.h"
#include "InsertDlg.h"
#include "FtpDlg.h"

#include "ImageDlg.h"
#include "ImageFile.h"

#include "MyString.h"
#include "BlogFile.h"
#include "DownloadFile.h"

#include "WinSCP.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#endif

const TCHAR c_cSlash = _T('/');
const TCHAR c_cWild = _T('*');
const CString c_strWild = _T("*.");
const CString c_strBackup = _T(".bak");
const CString c_strJEditBackup = _T("~");
const CString c_strName = _T("Woody's Web Tool");

void GetChineseName(CString & strName, CString strType)
{
	strName = strName.Left(strName.GetLength() - strType.GetLength()) + c_strChinese + strType;
}

static BOOL _IsFileType(CString str, const CString strType)
{
	return (str.Right(strType.GetLength()) == strType) ? TRUE : FALSE;
}

BOOL IsHtmlFile(CString str)
{
	return _IsFileType(str, c_strHtmlType);
}

BOOL IsPhpFile(CString str)
{
	return _IsFileType(str, c_strPhpType);
}

BOOL IsPythonFile(CString str)
{
	return _IsFileType(str, c_strPythonType);
}

BOOL IsAutoitFile(CString str)
{
	return _IsFileType(str, c_strAutoitType);
}

BOOL IsJsFile(CString str)
{
	return _IsFileType(str, c_strJsType);
}

BOOL IsCssFile(CString str)
{
	return _IsFileType(str, c_strCssType);
}

BOOL IsFileFolder(CString str)
{
	if (IsHtmlFile(str))	return FALSE;
	if (IsPhpFile(str))		return FALSE;
	if (IsPythonFile(str))	return FALSE;
	if (IsAutoitFile(str))	return FALSE;
	if (IsJsFile(str))		return FALSE;
	if (IsCssFile(str))		return FALSE;
	return TRUE;
}

BOOL IsEditFile(CString str)
{
	if (IsHtmlFile(str))	return TRUE;
	if (IsPhpFile(str))		return TRUE;
	if (IsPythonFile(str))	return TRUE;
	if (IsAutoitFile(str))	return TRUE;
	if (IsJsFile(str))		return TRUE;
//	if (IsCssFile(str))		return TRUE;
	return FALSE;
}

// CWebToolDoc

IMPLEMENT_DYNCREATE(CWebToolDoc, CDocument)

BEGIN_MESSAGE_MAP(CWebToolDoc, CDocument)
	ON_UPDATE_COMMAND_UI(ID_FILE_SAVE, &CWebToolDoc::OnUpdateFileSave)
	ON_COMMAND(ID_FILE_DIRECTORY, &CWebToolDoc::OnFileDirectory)
	ON_UPDATE_COMMAND_UI(ID_FILE_DIRECTORY, &CWebToolDoc::OnUpdateFileDirectory)
	ON_COMMAND(ID_TOOLS_ITERATE, &CWebToolDoc::OnToolsIterate)
	ON_COMMAND(ID_TOOLS_UNDO, &CWebToolDoc::OnToolsUndo)
	ON_UPDATE_COMMAND_UI(ID_TOOLS_UNDO, &CWebToolDoc::OnUpdateToolsUndo)
	ON_COMMAND(ID_TOOLS_OPTIONS, &CWebToolDoc::OnToolsOptions)
	ON_COMMAND(ID_TOOLS_FTP, &CWebToolDoc::OnToolsFtp)
	ON_COMMAND(ID_TREE_DELETE, &CWebToolDoc::OnTreeDelete)
	ON_COMMAND(ID_TREE_LOAD, &CWebToolDoc::OnTreeLoad)
	ON_UPDATE_COMMAND_UI(ID_TREE_LOAD, &CWebToolDoc::OnUpdateTreeLoad)
	ON_COMMAND(ID_TREE_INSERT, &CWebToolDoc::OnTreeInsert)
	ON_COMMAND(ID_TREE_COPY, &CWebToolDoc::OnTreeCopy)
	ON_UPDATE_COMMAND_UI(ID_TREE_COPY, &CWebToolDoc::OnUpdateTreeCopy)
	ON_COMMAND(ID_TOOLS_GENERATE_SITEMAP, &CWebToolDoc::OnToolsGenerateSitemap)
	ON_COMMAND(ID_TOOLS_CLEAR, &CWebToolDoc::OnToolsClear)
	ON_COMMAND(ID_TREE_DELETEEMPTY, &CWebToolDoc::OnTreeDeleteEmpty)
	ON_UPDATE_COMMAND_UI(ID_TREE_DELETEEMPTY, &CWebToolDoc::OnUpdateTreeDeleteEmpty)
	ON_COMMAND(ID_TREE_LOAD_NONEMPTY, &CWebToolDoc::OnTreeLoadNonEmpty)
	ON_UPDATE_COMMAND_UI(ID_TREE_LOAD_NONEMPTY, &CWebToolDoc::OnUpdateTreeLoadNonEmpty)
	ON_COMMAND(ID_TOOLS_GB2312TOUTF8, &CWebToolDoc::OnToolsGB2312ToUTF8)
	ON_COMMAND(ID_TOOLS_ADD_DOWNLOAD, &CWebToolDoc::OnToolsAddDownload)
	ON_COMMAND(ID_TOOLS_TOUCH, &CWebToolDoc::OnToolsTouch)
	ON_COMMAND(ID_TOOLS_ADD_IMAGE, &CWebToolDoc::OnToolsAddImage)
	ON_COMMAND(ID_WINSCP_EXE, &CWebToolDoc::OnWinscpExe)
	ON_COMMAND(ID_WINSCP_SCRIPT, &CWebToolDoc::OnWinscpScript)
	ON_COMMAND(ID_WINSCP_LOG, &CWebToolDoc::OnWinscpLog)
END_MESSAGE_MAP()


// CWebToolDoc construction/destruction

CWebToolDoc::CWebToolDoc()
: m_iVersion(4)
, m_strFtpDomain(_T("ftp.palmmicro.com"))
, m_strFtpSubDomain(_T(""))
, m_strFtpUserName(_T("anonymous"))
, m_strFtpPassword(_T(""))
, m_iFtpEncryption(0)
, m_iTreeLevel(0)
, m_iIterateFilesChanged(0)
, m_iFtpLastTime(0)
{
	m_strWinscpExe = AfxGetApp()->GetProfileString(_T("WinSCP"), _T("exe"), _T(""));
	m_strWinscpScript = AfxGetApp()->GetProfileString(_T("WinSCP"), _T("Script"), _T(""));
	m_strWinscpLog = AfxGetApp()->GetProfileString(_T("WinSCP"), _T("Log"), _T(""));
}

CWebToolDoc::~CWebToolDoc()
{
	AfxGetApp()->WriteProfileString(_T("WinSCP"), _T("exe"), m_strWinscpExe);
	AfxGetApp()->WriteProfileString(_T("WinSCP"), _T("Script"), m_strWinscpScript);
	AfxGetApp()->WriteProfileString(_T("WinSCP"), _T("Log"), m_strWinscpLog);
}

BOOL CWebToolDoc::OnNewDocument()
{
	if (!CDocument::OnNewDocument())
		return FALSE;

	// TODO: add reinitialization code here
	// (SDI documents will reuse this document)

	GetTreeCtrl().DeleteAllItems();
	AddFiles();

	return TRUE;
}

BOOL CWebToolDoc::OnOpenDocument(LPCTSTR lpszPathName)
{
	if (!CDocument::OnOpenDocument(lpszPathName))
		return FALSE;

	CString strPathName = lpszPathName;
	CString strPath = _GetPath(strPathName);

	::SetCurrentDirectory((LPCTSTR)strPath);
//	::OutputDebugString(strPath + _T("\n"));
	return TRUE;
}

// CWebToolDoc serialization

void CWebToolDoc::Serialize(CArchive& ar)
{
	CString str;

	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hCur;
	int iLevel;

	m_iTreeLevel = 0;
	if (ar.IsStoring())
	{
		m_iVersion = 4;		// always store with current version 4 format
		ar << m_iVersion << c_strName << m_strFtpDomain << m_strFtpSubDomain << m_strFtpUserName << m_strFtpPassword;
		
		// version 2 added
		ar << m_iFtpLastTime << m_strFtpLast;
		ar << m_timeFtpLast;

		// version 4 added
		ar << m_iFtpEncryption;

		hCur = ctrl.GetRootItem();
		StoringTree(ar, hCur);
		ar << 0;	// use 0 to mark the end of file

		if (m_strFtpPassword != _T(""))
		{
			AfxGetApp()->WriteProfileString(_T("LocalPassword"), m_strFtpDomain, m_strFtpPassword);
		}
	}
	else
	{
		ctrl.DeleteAllItems();

		ar >> m_iVersion;
		if (m_iVersion < 1 || m_iVersion > 4)
		{
			AfxMessageBox(_T("version error\n"));
			return;
		}

		ar >> str;
		if (str != c_strName)
		{
			AfxMessageBox(_T("format error\n"));
			return;
		}

		ar >> m_strFtpDomain >> m_strFtpSubDomain >> m_strFtpUserName >> m_strFtpPassword;
		if (m_iVersion >= 2)
		{
			// version 2 added
			ar >> m_iFtpLastTime >> m_strFtpLast;
			ar >> m_timeFtpLast;
		}

		if (m_iVersion >= 4)
		{
			// version 4 added
			ar >> m_iFtpEncryption;
		}

		ar >> iLevel;
		if (iLevel)
		{
			LoadingTree(ar, TVI_ROOT);
		}
	}
}


// CWebToolDoc diagnostics

#ifdef _DEBUG
void CWebToolDoc::AssertValid() const
{
	CDocument::AssertValid();
}

void CWebToolDoc::Dump(CDumpContext& dc) const
{
	CDocument::Dump(dc);
}
#endif //_DEBUG


// CWebToolDoc commands

CTreeCtrl & CWebToolDoc::GetTreeCtrl()
{
	return GetLeftView()->GetTreeCtrl();
}

CLeftView * CWebToolDoc::GetLeftView(void)
{
	POSITION pos;
	CLeftView * pView;
	
	pos = GetFirstViewPosition();
	pView = DYNAMIC_DOWNCAST(CLeftView, GetNextView(pos));
	return pView;
}

void CWebToolDoc::StoringTree(CArchive & ar, HTREEITEM hCur)
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	CString str;
	HTREEITEM hChild;
	BOOL bExpanded;

	m_iTreeLevel ++;
	while (hCur != NULL) 
	{
		str = ctrl.GetItemText(hCur);
		ar << m_iTreeLevel << str;
		if (IsFileFolder(str))
		{	// version 3 store extra expanded status of folers
			bExpanded = (ctrl.GetItemState(hCur, TVIS_EXPANDED) & TVIS_EXPANDED) ? TRUE : FALSE;
			ar << bExpanded;
		}
		if (ctrl.ItemHasChildren(hCur))
		{
			hChild = ctrl.GetChildItem(hCur);
			StoringTree(ar, hChild);
		}
		hCur = ctrl.GetNextItem(hCur, TVGN_NEXT);
	}
	m_iTreeLevel --;
}

int CWebToolDoc::LoadingTree(CArchive & ar, HTREEITEM hParent)
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	CString str;
	HTREEITEM hCur;
	int iLevel;
	BOOL bExpanded;

	m_iTreeLevel ++;
	while (1)
	{
		ar >> str;
		hCur = ctrl.InsertItem((LPCTSTR)str, hParent, TVI_SORT);
		if (IsFileFolder(str))
		{	// version 3 store extra expanded status of folers
			if (m_iVersion >= 3)	ar >> bExpanded;
			else					bExpanded = TRUE;

			ctrl.SetItemState(hCur, TVIS_BOLD, TVIS_BOLD);
		}
		ar >> iLevel;
		if (iLevel < m_iTreeLevel)
		{
			break;
		}
		else if (iLevel > m_iTreeLevel)
		{
			iLevel = LoadingTree(ar, hCur);
			if (ctrl.ItemHasChildren(hCur) && bExpanded)
			{
				ctrl.Expand(hCur, TVE_EXPAND);
			}
			if (iLevel == 0)
			{
				m_iTreeLevel = 0;
				return 0;
			}
			if (iLevel < m_iTreeLevel)
			{
				break;
			}
		}
	}
	m_iTreeLevel --;
	return iLevel;
}

void CWebToolDoc::OnUpdateFileSave(CCmdUI *pCmdUI)
{
	pCmdUI->Enable(IsModified());
}

void CWebToolDoc::GetItemPath(HTREEITEM hCur, CString & str, const TCHAR c)
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hParent, hPrev;

	str = ctrl.GetItemText(hCur);
	hPrev = hCur;
	do
	{
		hParent = ctrl.GetParentItem(hPrev);
		if (hParent)
		{
			str = ctrl.GetItemText(hParent) + c + str;
			hPrev = hParent;
		}
	} while (hParent);
}

void CWebToolDoc::AddFiles(HTREEITEM hParent)
{
	CFileFind finder;
	CString str, strPath;
	CStringList list;
	BOOL bWorking;
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hCur;

	if (hParent == TVI_ROOT)
	{
		strPath = _T("");
		hCur = ctrl.GetRootItem();
	}
	else
	{
		GetItemPath(hParent, strPath, c_cBackSlash);
		strPath += c_cBackSlash;
		hCur = ctrl.GetChildItem(hParent);
	}

	while (hCur != NULL)
	{
		str = ctrl.GetItemText(hCur);
		list.AddTail(str);
		hCur = ctrl.GetNextItem(hCur, TVGN_NEXT);
	}

	bWorking = finder.FindFile(strPath + c_strWild);
	while (bWorking)
	{
		bWorking = finder.FindNextFile();
		str = finder.GetFileName();
		if (list.Find(str) == NULL)
		{
			if (finder.IsDirectory())
			{
				if (!finder.IsSystem() && !finder.IsHidden() && !finder.IsCompressed() && !finder.IsDots())
				{
					hCur = ctrl.InsertItem((LPCTSTR)str, hParent, TVI_SORT);
					ctrl.SetItemState(hCur, TVIS_BOLD, TVIS_BOLD);
					SetModifiedFlag(TRUE);
				}
			}
		}
	}	 

	AddFilesByType(hParent, list, strPath + c_cWild + c_strHtmlType);
	AddFilesByType(hParent, list, strPath + c_cWild + c_strPhpType);
	AddFilesByType(hParent, list, strPath + c_cWild + c_strPythonType);
	AddFilesByType(hParent, list, strPath + c_cWild + c_strAutoitType);
	AddFilesByType(hParent, list, strPath + c_cWild + c_strJsType);
	AddFilesByType(hParent, list, strPath + c_cWild + c_strCssType);
}

void CWebToolDoc::AddFilesByType(HTREEITEM hParent, CStringList & list, CString strType)
{
	CFileFind finder;
	CString str;
	BOOL bWorking;
	CTreeCtrl & ctrl = GetTreeCtrl();

	bWorking = finder.FindFile(strType);
	while (bWorking)
	{
		bWorking = finder.FindNextFile();
		str = finder.GetFileName();
		if (list.Find(str) == NULL)
		{
			ctrl.InsertItem((LPCTSTR)str, hParent, TVI_SORT);
			SetModifiedFlag(TRUE);
		} 
	}
}

void CWebToolDoc::OnItemSelected()
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hItem = ctrl.GetSelectedItem();
//	HTREEITEM hParent;
	CString str;
	CString strPathName;
//	BOOL bViewPhp;

	str = ctrl.GetItemText(hItem);
/*	if (IsPhpFile(str))
	{
		hParent = ctrl.GetParentItem(hItem);
		bViewPhp = (ctrl.GetItemText(hParent) == _T("php")) ? FALSE : TRUE;	// php only .php files are stored in "php" dir only
	}
	else
	{
		bViewPhp = FALSE;
	}

	if (IsHtmlFile(str) || bViewPhp)*/
	if (IsHtmlFile(str))
	{
		GetItemPathName(hItem, strPathName);
		((CMainFrame *)AfxGetMainWnd())->UpdateHtmlFile(strPathName);
	}
}

void CWebToolDoc::OnItemMoved()
{
	GetTreeCtrl().SelectItem(NULL);
}

void CWebToolDoc::GetItemPathName(HTREEITEM hCur, CString & strPathName)
{
	CString str;
	CString strPath;
	TCHAR lpPath[MAX_PATH];

	::GetCurrentDirectory(MAX_PATH, lpPath);
	strPath = lpPath;
	GetItemPath(hCur, str, c_cBackSlash);
	strPathName = strPath + c_cBackSlash + str;
}

void CWebToolDoc::OnFileDirectory()
{
	CDirectoryDlg dlg;
	if (dlg.DoModal() != IDOK)	return;

	CString strPathName = dlg.GetPathName();
	CString strName = dlg.GetFileName();
	CString strDir = strPathName.Left(strPathName.GetLength() - strName.GetLength());
	CTreeCtrl & ctrl = GetTreeCtrl();

	if (::SetCurrentDirectory((LPCTSTR)strDir))
	{
		ctrl.DeleteAllItems();

		((CMainFrame*)AfxGetMainWnd())->UpdateStatus(strDir);
		AddFiles();
	}
}

void CWebToolDoc::OnUpdateFileDirectory(CCmdUI *pCmdUI)
{
	CString str = GetPathName();
	pCmdUI->Enable(str.GetLength() ? FALSE : TRUE);
}

void CWebToolDoc::OnToolsIterate()
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hCur, hItem;
	CIterateDlg dlg;
	CTxtFile file;
	CString str;

	dlg.m_bFolderSelected = IsFileFolderSelected();
	if (dlg.DoModal() != IDOK)	return;

	if ((dlg.m_iOperation == eOpInsertNext || dlg.m_iOperation == eOpInsertPrev) && dlg.m_bInsertMultiStr)
	{
		if (!file.ReadToStringList(dlg.m_strTxtFile, m_listTxtFile))		return;
	}

	AfxGetApp()->DoWaitCursor(1); // 1->>display the hourglass cursor
	ToolsIterateItem(GetTreeCtrl().GetRootItem(), NULL);	// clear all old backup files first
	m_iIterateFilesChanged = 0;
	m_iTreeLevel = 0;
	if (dlg.m_bFolderOnly)
	{	// folder selected
		hItem = ctrl.GetSelectedItem();
		hCur = ctrl.GetChildItem(hItem);
		do
		{
			m_iTreeLevel ++;
			hItem = ctrl.GetParentItem(hItem);
		} while (hItem);
	}
	else
	{
		hCur = ctrl.GetRootItem();	// start with root
	}
	ToolsIterateItem(hCur, &dlg);
	AfxGetApp()->DoWaitCursor(-1); // -1->>remove the hourglass cursor

	str.Format(_T("%d files changed"), m_iIterateFilesChanged);
	AfxMessageBox(str, MB_OK | MB_ICONINFORMATION);

	m_listTxtFile.RemoveAll();
}

void CWebToolDoc::ToolsIterateItem(HTREEITEM hCur, CIterateDlg * pDlg)
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	CString str;
	CString strPathName;
	HTREEITEM hChild;
	BOOL bRecursive;

	if (pDlg)
	{
		bRecursive = pDlg->m_bFolderRecursive;
	}
	else
	{

		bRecursive = TRUE;
	}

	m_iTreeLevel ++;
	while (hCur != NULL) 
	{
		str = ctrl.GetItemText(hCur);
		if (IsEditFile(str))
		{
			GetItemPathName(hCur, strPathName);
			ToolsIterateFile(strPathName, pDlg);
		}
		if (bRecursive)
		{
			if (ctrl.ItemHasChildren(hCur))
			{
				hChild = ctrl.GetChildItem(hCur);
				ToolsIterateItem(hChild, pDlg);
			}
		}
		hCur = ctrl.GetNextItem(hCur, TVGN_NEXT);
	}
	m_iTreeLevel --;
}

void CWebToolDoc::ToolsIterateFile(CString strPathName, CIterateDlg * pDlg)
{
	CFileStatus status;
	CTxtFile file;
	CStringList list;
	BOOL bChanged;

	// remove any existed previous back up file
	if (CFile::GetStatus(strPathName + c_strBackup, status))
	{
		CFile::Remove(strPathName + c_strBackup);
	}

	// remove jedit back up file
	if (CFile::GetStatus(strPathName + c_strJEditBackup, status))
	{
		CFile::Remove(strPathName + c_strJEditBackup);
	}

	if (pDlg == NULL)	return;

	if (!file.ReadToStringList(strPathName, list))	return;

	// process
	if (pDlg->m_iOperation >= eOpReplace)
	{
		bChanged = IterateFileForward(pDlg, list);
	}
	else
	{
		bChanged = IterateFileBackward(pDlg, list);
	}

	if (bChanged)		// need to backup and rewrite
	{
		// backup
		CFile::Rename(strPathName, strPathName + c_strBackup);
		file.WriteFromStringList(strPathName, list);
		m_iIterateFilesChanged ++;
	}

//	::OutputDebugString(strPathName + c_cNewLine);
}

CString CWebToolDoc::AddPath(CIterateDlg * pDlg)
{
	CString strNew = pDlg->m_strNew;
	CString strAddPath;
	int i, iFindNew;

	if (pDlg->m_bReplaceAddPath)
	{
		iFindNew = strNew.Find(_T('='));
		if (iFindNew != -1)
		{
			strAddPath = _T("");
			for (i = 1; i < m_iTreeLevel; i++)
			{
				strAddPath += _T("../");
			}
			iFindNew++;
			if (strNew.GetAt(iFindNew) == '\"')		iFindNew++;	// bypass " after =
			strNew = strNew.Left(iFindNew) + strAddPath + strNew.Right(strNew.GetLength() - iFindNew);
		}
	}
	return strNew;
}

BOOL CWebToolDoc::IterateFileForward(CIterateDlg * pDlg, CStringList & list)
{
	CString str;
	CString strNew;
	int i, iFind;
	POSITION pos, old, pos2;
	BOOL bChanged = FALSE;

	for (pos = list.GetHeadPosition(); pos != NULL;)
	{
		old = pos;
		str = list.GetNext(pos);
		iFind = str.Find(pDlg->m_strMatch);
		if (iFind != -1)
		{
			strNew = AddPath(pDlg);
			if (pDlg->m_iOperation == eOpReplace)
			{
				if (pDlg->m_bReplaceMatchOnly)
				{
					str = str.Left(iFind) + strNew + str.Right(str.GetLength() - pDlg->m_strMatch.GetLength() - iFind);
					list.SetAt(old, str);
				}
				else
				{
					if (strNew.IsEmpty())
					{
						list.RemoveAt(old);
					}
					else
					{
						list.SetAt(old, strNew);
					}
				}
			}
			else if (pDlg->m_iOperation == eOpInsertNext)
			{
				if (pDlg->m_bInsertMultiStr)
				{
					for (pos2 = m_listTxtFile.GetTailPosition(); pos2 != NULL;)
					{
						str = m_listTxtFile.GetPrev(pos2);
						list.InsertAfter(old, str);
					}
				}
				else
				{
					list.InsertAfter(old, strNew);
				}
			}
			else
			{
				if (pDlg->m_bRemoveMultiLine)
				{
					for (i = 0; i < (int)pDlg->m_iLineNum; i++)
					{
						old = pos;
						list.GetNext(pos);
						list.RemoveAt(old);
					}
				}
				else
				{
					list.RemoveAt(pos);
				}
			}
			bChanged = TRUE;
			break;
		}
	}

	return bChanged;
}

BOOL CWebToolDoc::IterateFileBackward(CIterateDlg * pDlg, CStringList & list)
{
	int i;
	CString str;
	CString strNew;
	POSITION pos, old, pos2;
	BOOL bChanged = FALSE;

	for (pos = list.GetTailPosition(); pos != NULL;)
	{
		old = pos;
		str = list.GetPrev(pos);
		if (str.Find(pDlg->m_strMatch) != -1)
		{
			strNew = AddPath(pDlg);
			if (pDlg->m_iOperation == eOpInsertPrev)
			{
				if (pDlg->m_bInsertMultiStr)
				{
					for (pos2 = m_listTxtFile.GetHeadPosition(); pos2 != NULL;)
					{
						str = m_listTxtFile.GetNext(pos2);
						list.InsertBefore(old, str);
					}
				}
				else
				{
					list.InsertBefore(old, strNew);
				}
			}
			else
			{
				if (pDlg->m_bRemoveMultiLine)
				{
					for (i = 0; i < (int)pDlg->m_iLineNum; i++)
					{
						old = pos;
						list.GetPrev(pos);
						list.RemoveAt(old);
					}
				}
				else
				{
					list.RemoveAt(pos);
				}
			}
			bChanged = TRUE;
			break;
		}
	}

	return bChanged;
}

void CWebToolDoc::OnToolsGenerateSitemap()
{
	CTxtFile file;
	CString str;
	CString strDomain;
	CStringList list;
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hCur;

	strDomain = _T("http://") + m_strFtpDomain.Right(m_strFtpDomain.GetLength() - 4) + c_cSlash;
	if (!m_strFtpSubDomain.IsEmpty())
	{
		strDomain += m_strFtpSubDomain + c_cSlash;
	}
	str.Format(_T("Generate %s sitemap?"), strDomain);
	if (AfxMessageBox(str, MB_YESNO | MB_ICONQUESTION) != IDYES)
	{
		return;
	}

	list.AddTail(_T("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"));
	list.AddTail(_T("<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">"));
//	list.AddTail(_T("<url><loc>") + strDomain + _T("</loc></url>"));

	hCur = ctrl.GetRootItem();
	ToolsGenerateSitemap(hCur, strDomain, list);

	list.AddTail(_T("</urlset>"));
	file.WriteFromStringList(_T("sitemap.xml"), list);
	str.Format(_T("Generate sitemap.xml successfully"));
	AfxMessageBox(str, MB_OK | MB_ICONINFORMATION);
}

void CWebToolDoc::ToolsGenerateSitemap(HTREEITEM hCur, CString strDomain, CStringList & list)
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	CString str;
	CString strPath;
//	CString strPathName;
//	CString strLastMod;
//	CFileStatus status;
	HTREEITEM hChild;

	while (hCur != NULL) 
	{
		str = ctrl.GetItemText(hCur);
		if (str.Right(6) == _T("index."))
//		if (IsHtmlFile(str))
		{
			GetItemPath(hCur, strPath, c_cSlash);
			strPath = strPath.Left(strPath.GetLength() - str.GetLength());
			list.AddTail(_T("<url><loc>") + strDomain + strPath + _T("</loc></url>"));
/*			GetItemPathName(hCur, strPathName);
			if (CFile::GetStatus(strPathName, status))
			{
				strLastMod = status.m_mtime.Format(_T("%Y-%m-%dT%H:%M:%SZ"));
				list.AddTail(_T("<url><loc>") + strDomain + strPath + _T("</loc><lastmod>") + strLastMod + _T("</lastmod></url>"));
			}
*/
		}
		if (ctrl.ItemHasChildren(hCur))
		{
			hChild = ctrl.GetChildItem(hCur);
			ToolsGenerateSitemap(hChild, strDomain, list);
		}
		hCur = ctrl.GetNextItem(hCur, TVGN_NEXT);
	}
}

void CWebToolDoc::OnToolsClear()
{
	if (AfxMessageBox(_T("Clear all undo files?"), MB_YESNO | MB_ICONQUESTION) != IDYES)
	{
		return;
	}

	ToolsIterateItem(GetTreeCtrl().GetRootItem(), NULL);
	m_iIterateFilesChanged = 0;
}

void CWebToolDoc::OnToolsUndo()
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hCur;
	CString str;

	str.Format(_T("Undo all %d files?"), m_iIterateFilesChanged);
	if (AfxMessageBox(str, MB_YESNO | MB_ICONQUESTION) != IDYES)
	{
		return;
	}

	AfxGetApp()->DoWaitCursor(1); // 1->>display the hourglass cursor
	hCur = ctrl.GetRootItem();
	ToolsUndoItem(hCur);
	AfxGetApp()->DoWaitCursor(-1); // -1->>remove the hourglass cursor

	if (m_iIterateFilesChanged != 0)
	{
		str.Format(_T("undo %d files failed"), m_iIterateFilesChanged);
		AfxMessageBox(str, MB_OK | MB_ICONSTOP);
		m_iIterateFilesChanged = 0;
	}
	else
	{
		str.Format(_T("Undo all files successfully"));
		AfxMessageBox(str, MB_OK | MB_ICONINFORMATION);
	}
}

void CWebToolDoc::OnUpdateToolsUndo(CCmdUI *pCmdUI)
{
	pCmdUI->Enable(m_iIterateFilesChanged > 0 ? TRUE : FALSE);
}

void CWebToolDoc::ToolsUndoItem(HTREEITEM hCur)
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	CString str;
	CString strPathName;
	HTREEITEM hChild;
	CFileStatus status;

	while (hCur != NULL) 
	{
		str = ctrl.GetItemText(hCur);
		if (IsEditFile(str))
		{
			GetItemPathName(hCur, strPathName);
			if (CFile::GetStatus(strPathName + c_strBackup, status))
			{
				CFile::Remove(strPathName);
				CFile::Rename(strPathName + c_strBackup, strPathName);
				m_iIterateFilesChanged --;
			}
		}
		if (ctrl.ItemHasChildren(hCur))
		{
			hChild = ctrl.GetChildItem(hCur);
			ToolsUndoItem(hChild);
		}
		hCur = ctrl.GetNextItem(hCur, TVGN_NEXT);
	}
}

void CWebToolDoc::OnToolsOptions()
{
	COptionsDlg dlg;

	dlg.m_strFtpDomain = m_strFtpDomain;
	dlg.m_strFtpSubDomain = m_strFtpSubDomain;
	dlg.m_strFtpUserName = m_strFtpUserName;
	dlg.m_strFtpPassword = m_strFtpPassword;
	dlg.m_iFtpEncryption = 	m_iFtpEncryption;

	if (dlg.DoModal() != IDOK)	return;

	m_strFtpDomain = dlg.m_strFtpDomain;
	m_strFtpSubDomain = dlg.m_strFtpSubDomain;
	m_strFtpUserName = dlg.m_strFtpUserName;
	m_strFtpPassword = dlg.m_strFtpPassword;
	m_iFtpEncryption = 	dlg.m_iFtpEncryption;
	SetModifiedFlag(TRUE);
}

void CWebToolDoc::OnToolsFtp()
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	CString str;
	HTREEITEM hCur;
	CFtpDlg dlg;
	CFileStatus status;
	CTime t = CTime::GetCurrentTime();
	int iTotal;
	UINT iIcon;

	dlg.m_iLastTime = m_iFtpLastTime;
	if (m_strFtpLast.IsEmpty())
	{
		dlg.m_strFileName = _T("(Select reference time file by click the \"Browse...\" button)");
	}
	else
	{
		dlg.m_strFileName = m_strFtpLast;
	}
	dlg.m_strTime = m_timeFtpLast.Format(_T("%A, %B %d, %H:%M:%S, %Y"));
	if (dlg.DoModal() != IDOK)	return;

	m_iFtpLastTime = dlg.m_iLastTime;
	m_strFtpLast = dlg.m_strFileName;
	
	if (m_iFtpLastTime == eFtpLastFile)
	{
		if (!CFile::GetStatus(dlg.m_strFileName, status))
		{
			AfxMessageBox(_T("No valid reference time file selected"), MB_OK | MB_ICONSTOP);
			return;
		}
		m_timeFtpCompare = status.m_mtime;
	}
	else
	{
		m_timeFtpCompare = m_timeFtpLast;
	}
	str = m_timeFtpCompare.Format(_T("%A, %B %d, %H:%M:%S, %Y\n"));
	::OutputDebugString(str);

	m_pFtp = NULL;
	str.Format(_T("Connecting to FTP server at %s"), m_strFtpDomain);
	((CMainFrame*)AfxGetMainWnd())->UpdateStatus(str);
	AfxGetApp()->DoWaitCursor(1); // 1->>display the hourglass cursor
	hCur = ctrl.GetRootItem();

	m_pFtp = new WinSCP();
	ToolsFtpItem(hCur);
	CString strPassword = m_strFtpPassword;
	if (strPassword == _T(""))
	{
		strPassword = AfxGetApp()->GetProfileString(_T("LocalPassword"), m_strFtpDomain, _T(""));
	}
	iTotal = m_pFtp->UpLoad(m_strWinscpExe, m_strWinscpScript, m_strWinscpLog, m_strFtpDomain, m_strFtpUserName, strPassword, m_iFtpEncryption);
	delete m_pFtp;

	AfxGetApp()->DoWaitCursor(-1); // -1->>remove the hourglass cursor
	if (iTotal > 0)
	{
		m_timeFtpLast = t;
		str.Format(_T("Total %d files uploaded FTP server at %s"), iTotal, m_strFtpDomain);
		iIcon = MB_ICONINFORMATION;
		SetModifiedFlag(TRUE);
	}
	else if (iTotal == 0)
	{
		str.Format(_T("No file uploaded FTP server at %s"), m_strFtpDomain);
		iIcon = MB_ICONWARNING;
	}
	else
	{
		str.Format(_T("FTP server connection failed at %s"), m_strFtpDomain);
		iIcon = MB_ICONSTOP;
	}
	AfxMessageBox(str, MB_OK | iIcon);
}

void CWebToolDoc::ToolsFtpItem(HTREEITEM hCur)
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	CString str;
	CString strPath;
	CString strPathName;
	CString strSubDomain;
	HTREEITEM hChild;
	CFileStatus status;

	strSubDomain = m_strFtpSubDomain;
	if (!strSubDomain.IsEmpty())
	{
		strSubDomain += c_cSlash;
	}
	while (hCur != NULL) 
	{
		str = ctrl.GetItemText(hCur);
		if (!IsFileFolder(str))
		{
			GetItemPathName(hCur, strPathName);
			if (CFile::GetStatus(strPathName, status))
			{
				if (status.m_mtime >= m_timeFtpCompare)
				{
					GetItemPath(hCur, strPath, c_cSlash);
					m_pFtp->AddFile(strPathName, strSubDomain + strPath);
					str = _T("Put ") + strPathName + _T(" to FTP ") + strPath;
					::OutputDebugString(str + c_cNewLine);
					((CMainFrame*)AfxGetMainWnd())->UpdateStatus(str);
				}
			}
		}
		if (ctrl.ItemHasChildren(hCur))
		{
			hChild = ctrl.GetChildItem(hCur);
			ToolsFtpItem(hChild);
		}
		hCur = ctrl.GetNextItem(hCur, TVGN_NEXT);
	}
}

void CWebToolDoc::OnToolsGB2312ToUTF8()
{
	if (AfxMessageBox(_T("Are you sure to convert all files from GB2312 to UTF8?"), MB_YESNO | MB_ICONQUESTION) != IDYES)
	{
		return;
	}

	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hCur;

	AfxGetApp()->DoWaitCursor(1); // 1->>display the hourglass cursor
	hCur = ctrl.GetRootItem();
	ToolsGB2312ToUTF8Item(hCur);
	AfxGetApp()->DoWaitCursor(-1); // -1->>remove the hourglass cursor
}

void CWebToolDoc::ToolsGB2312ToUTF8Item(HTREEITEM hCur)
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	CString str;
	CString strPathName;
	HTREEITEM hChild;
	CTxtFile file;

	while (hCur != NULL) 
	{
		str = ctrl.GetItemText(hCur);
		if (!IsFileFolder(str))
		{
			GetItemPathName(hCur, strPathName);
			file.GB2312ToUTF8(strPathName);
		}
		if (ctrl.ItemHasChildren(hCur))
		{
			hChild = ctrl.GetChildItem(hCur);
			ToolsGB2312ToUTF8Item(hChild);
		}
		hCur = ctrl.GetNextItem(hCur, TVGN_NEXT);
	}
}

void CWebToolDoc::OnTreeDelete()
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hCur = ctrl.GetSelectedItem();

	ctrl.DeleteItem(hCur);
	SetModifiedFlag(TRUE);
}

void CWebToolDoc::OnTreeLoad()
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hItem = ctrl.GetSelectedItem();
	CString str;
	CString strPathName;

	str = ctrl.GetItemText(hItem);
	if (IsFileFolder(str))
	{
		AddFiles(hItem);
		if (ctrl.ItemHasChildren(hItem))
		{
			ctrl.Expand(hItem, TVE_EXPAND);
		}
	}
}

void CWebToolDoc::OnUpdateTreeLoad(CCmdUI *pCmdUI)
{
	pCmdUI->Enable(IsFileFolderSelected());
}

void CWebToolDoc::OnTreeInsert()
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hItem = ctrl.GetSelectedItem();
	HTREEITEM hParent = ctrl.GetParentItem(hItem);

	AddFiles((hParent == NULL) ? TVI_ROOT : hParent);
}


BOOL CWebToolDoc::IsBlogItem(HTREEITEM hItem)
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hCur;
	CString str;
	
	hCur = ctrl.GetParentItem(hItem);
	hCur = ctrl.GetParentItem(hCur);
	str = ctrl.GetItemText(hCur);

	return (str == _T("blog")) ? TRUE : FALSE;
}

BOOL CWebToolDoc::IsFormItem(HTREEITEM hItem)
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	CString str;

	str = ctrl.GetItemText(hItem);

	return (str.Right(8) == _T("form.php")) ? TRUE : FALSE;
}

// _edittransactionform.php -> _submitstransaction.php
void CWebToolDoc::InsertFormFiles(CInsertDlg & dlg, CString strPathName, HTREEITEM hParent)
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	CTxtFile file;

	// strPathName = C:\Palmmicro Web\woody\res\php\_edittransactionform.php
	CString strPath = _GetPath(strPathName);									// C:\Palmmicro Web\woody\res\php
	CString strFileName = _GetFileName(strPathName);							// _edittransactionform.php

	CString strOld = strFileName.Right(strFileName.GetLength() - 5);			// transactionform.php
	strOld = strOld.Left(strOld.GetLength() - 8);								// transaction

	CString strNew = dlg.m_strName.Right(dlg.m_strName.GetLength() - 5);		// newform
	strNew = strNew.Left(strNew.GetLength() - 4);								// new

	if (file.CopyAndReplaceFile(strPath + c_cBackSlash + _T("_submit") + strOld + c_strPhpType, strOld, strNew, dlg.m_bReplace))
	{
		ctrl.InsertItem(_T("_submit") + strNew + c_strPhpType, hParent, TVI_SORT);
	}
//	OutputDebugString(strOld);
}

void CWebToolDoc::OnTreeCopy()
{
	CInsertDlg dlg;
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hItem = ctrl.GetSelectedItem();
	HTREEITEM hParent;
	CString str;
	CString strName;
	CString strType;
	CString strPathName;
	CBlogFile file;

	str = ctrl.GetItemText(hItem);
	if (IsHtmlFile(str))		strType = c_strHtmlType;
	else if (IsPhpFile(str))	strType = c_strPhpType;
	else						return;

	strName = str.Left(str.GetLength() - strType.GetLength());
	dlg.m_strName = strName;
	dlg.m_bChinese = (strName.Right(c_strChinese.GetLength()) == c_strChinese) ? FALSE : TRUE;
	dlg.m_bReplace = dlg.m_bChinese;
	dlg.m_bModifyBlog = IsBlogItem(hItem);
	dlg.m_bInsertForm = IsFormItem(hItem);
	if (dlg.DoModal() != IDOK)	return;

	GetItemPathName(hItem, strPathName);
	if (file.CopyAndReplaceFile(strPathName, strName, dlg.m_strName, dlg.m_bReplace))
	{
		hParent = ctrl.GetParentItem(hItem);
		if (hParent == NULL)
		{
			hParent = ctrl.GetRootItem();
		}
		ctrl.InsertItem(dlg.m_strName + strType, hParent, TVI_SORT);
		SetModifiedFlag(TRUE);
		if (dlg.m_bChinese)
		{
			GetChineseName(strPathName, strType);
			if (file.CopyAndReplaceFile(strPathName, strName, dlg.m_strName, dlg.m_bReplace))
			{
				ctrl.InsertItem(dlg.m_strName + c_strChinese + strType, hParent, TVI_SORT);
			}
		}
		else if (dlg.m_bInsertForm)
		{	// _edittransactionform.php -> _submitstransaction.php
			InsertFormFiles(dlg, strPathName, hParent);
		}
	}
/*
	if (!dlg.m_bModifyBlog)		return;

	str = ctrl.GetItemText(hParent);
	GetItemPathName(hParent, strPathName);
	file.ModifyJs(dlg.m_strName, strPathName, str);

	file.Modify(dlg.m_strTitle, dlg.m_strImageText, FALSE);
	if (dlg.m_bChinese)
	{
		file.Modify(dlg.m_strChineseTitle, dlg.m_strImageText, TRUE);
	}

	file.ModifyParent(dlg.m_strTitle, dlg.m_strImageText, FALSE);
	if (dlg.m_bChinese)
	{
		file.ModifyParent(dlg.m_strChineseTitle, dlg.m_strImageText, TRUE);
	}

	hItem = ctrl.GetParentItem(hParent);
	str = ctrl.GetItemText(hItem);
	GetItemPathName(hItem, strPathName);
	file.ModifyRoot(strPathName, str, dlg.m_strTitle, FALSE);
	if (dlg.m_bChinese)
	{
		file.ModifyRoot(strPathName, str, dlg.m_strChineseTitle, TRUE);
	}
*/
}

void CWebToolDoc::OnUpdateTreeCopy(CCmdUI *pCmdUI)
{
	pCmdUI->Enable(IsHtmlFileSelected() || IsPhpFileSelected());
}

BOOL CWebToolDoc::IsHtmlFileSelected()
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hItem = ctrl.GetSelectedItem();
	CString str;

	if (hItem)
	{
		str = ctrl.GetItemText(hItem);
		return IsHtmlFile(str);
	}
	return FALSE;
}

BOOL CWebToolDoc::IsPhpFileSelected()
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hItem = ctrl.GetSelectedItem();
	CString str;

	if (hItem)
	{
		str = ctrl.GetItemText(hItem);
		return IsPhpFile(str);
	}
	return FALSE;
}

BOOL CWebToolDoc::IsFileFolderSelected()
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hItem = ctrl.GetSelectedItem();
	CString str;

	if (hItem)
	{
		str = ctrl.GetItemText(hItem);
		return IsFileFolder(str);
	}
	return FALSE;
}

void CWebToolDoc::OnTreeDeleteEmpty()
{
	CTreeCtrl & ctrl = GetTreeCtrl();
	HTREEITEM hItem = ctrl.GetSelectedItem();
	HTREEITEM hCur, hOld;
	CString str;

	if (!hItem)		return;
	if (!ctrl.ItemHasChildren(hItem))	return;

	hCur = ctrl.GetChildItem(hItem);
	while (hCur)
	{
		hOld = hCur;
		hCur = ctrl.GetNextItem(hOld, TVGN_NEXT);
		str = ctrl.GetItemText(hOld);
		if (IsFileFolder(str) && !ctrl.ItemHasChildren(hOld))
		{
			ctrl.DeleteItem(hOld);
			SetModifiedFlag(TRUE);
		}
	}
}

void CWebToolDoc::OnUpdateTreeDeleteEmpty(CCmdUI *pCmdUI)
{
	pCmdUI->Enable(IsFileFolderSelected());
}


void CWebToolDoc::OnTreeLoadNonEmpty()
{
	OnTreeLoad();
	OnTreeDeleteEmpty();
}

void CWebToolDoc::OnUpdateTreeLoadNonEmpty(CCmdUI *pCmdUI)
{
	OnUpdateTreeLoad(pCmdUI);
}

void CWebToolDoc::OnToolsTouch()
{
	if (AfxMessageBox(_T("Set current time for current .wwt modified time?"), MB_YESNO | MB_ICONQUESTION) != IDYES)
	{
		return;
	}
	m_timeFtpLast = CTime::GetCurrentTime();
	AfxMessageBox(_T("Time updated"), MB_OK | MB_ICONINFORMATION);
	SetModifiedFlag(TRUE);
}

void CWebToolDoc::OnToolsAddDownload()
{
	CDownloadFile file;
	CFileDialog dlg(TRUE, _T("*.zip"), _T(""), OFN_FILEMUSTEXIST | OFN_PATHMUSTEXIST, _T("Download files (*.zip)|*.zip|"));

	if (dlg.DoModal() != IDOK)	return;

	//	dlg.GetFileName());
	if (file.Modify(dlg.GetPathName()))
	{
		AfxMessageBox(_T("Operation ok"), MB_OK | MB_ICONINFORMATION);
	}
	else
	{
		AfxMessageBox(_T("Operation failed"), MB_OK | MB_ICONSTOP);
	}
}


void CWebToolDoc::OnToolsAddImage()
{
	CImageDlg dlg;
	CImageFile file;

	if (dlg.DoModal() != IDOK)	return;

	OutputDebugString(dlg.m_strFileName + _T("\n"));
	OutputDebugString(dlg.m_strTitle + _T("\n"));
	OutputDebugString(dlg.m_strChineseTitle + _T("\n"));
	OutputDebugString(dlg.m_strAltText + _T("\n"));

	if (file.Modify(dlg.m_strFileName, dlg.m_strTitle, dlg.m_strChineseTitle, dlg.m_strAltText))
	{
		AfxMessageBox(_T("Operation ok"), MB_OK | MB_ICONINFORMATION);
	}
	else
	{
		AfxMessageBox(_T("Operation failed"), MB_OK | MB_ICONSTOP);
	}
}


void CWebToolDoc::OnWinscpExe()
{
	CFileDialog dlg(TRUE, _T("*.exe"), m_strWinscpExe, OFN_FILEMUSTEXIST | OFN_PATHMUSTEXIST, _T("Exe files (*.exe)|*.exe|"));

	if (dlg.DoModal() == IDOK)
	{
		m_strWinscpExe = dlg.GetPathName();
	}
}

void CWebToolDoc::OnWinscpScript()
{
	CFileDialog dlg(FALSE, _T("*.txt"), m_strWinscpScript, OFN_PATHMUSTEXIST, _T("Script files (*.txt)|*.txt|"));

	if (dlg.DoModal() == IDOK)
	{
		m_strWinscpScript = dlg.GetPathName();
	}
}


void CWebToolDoc::OnWinscpLog()
{
	CFileDialog dlg(FALSE, _T("*.txt"), m_strWinscpLog, OFN_PATHMUSTEXIST, _T("Log files (*.txt)|*.txt|"));

	if (dlg.DoModal() == IDOK)
	{
		m_strWinscpLog = dlg.GetPathName();
	}
}
