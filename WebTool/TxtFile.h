#pragma once
#include "afx.h"
#include "StdioFileEx.h"

extern const TCHAR c_cNewLine;
extern const TCHAR c_cBackSlash;

BOOL ReplaceString(CString & str, CString strOld, CString strNew);
CString _GetPath(CString strPathName);
CString _GetFileName(CString strPathName);

class CTxtFile : public CStdioFileEx
{
public:
	CTxtFile();
	~CTxtFile();

	bool ReadToStringList(CString strFileName, CStringList & list);
	bool WriteFromStringList(CString strFileName, CStringList & list);

	bool ReadGB2312ToStringList(CString strFileName, CStringList & list);
	bool WriteGB2312FromStringList(CString strFileName, CStringList & list);

	bool CopyAndReplaceFile(CString strFileName, CString strOld, CString strNew, BOOL bReplace);
	bool GB2312ToUTF8(CString strFileName);
};
