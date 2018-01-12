#pragma once
#include "TxtFile.h"
#include "DateStrings.h"

extern const CString c_strJsType;
extern const CString c_strCssType;
extern const CString c_strPhpType;
extern const CString c_strHtmlType;
extern const CString c_strChinese;

class CBlogFile : public CTxtFile, public CDateStrings
{
public:
	CBlogFile();
	~CBlogFile();

	bool ModifyJs(CString strName, CString strParentPath, CString strParentName);
	bool Modify(CString strTitle, CString strImageText, bool bChinese);
	bool ModifyParent(CString strTitle, CString strImageText, bool bChinese);
	bool ModifyRoot(CString strRootPath, CString strRootName, CString strTitle, bool bChinese);

protected:
	CString m_strName;
	CString m_strPhoto;

	CString m_strParentName;
	CString m_strParentPath;

protected:
	bool HasJpgFile();

private:
	bool _ModifyJsFile(CString strFileName, CString strName, bool bModifyNum);
};
