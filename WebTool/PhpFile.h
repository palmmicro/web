#pragma once
#include "TxtFile.h"
#include "DateStrings.h"

class CPhpFile :
	public CTxtFile, public CDateStrings
{
public:
	CPhpFile();
	~CPhpFile();

protected:
	bool GetFileName(CString strPathName);
	bool GetFileDate(CString strPathName);

	bool GetFileNameDate();

	bool InsertFile(CString strFileName, CString strInsert, CString strFind);

protected:
	CString m_strFileName;
};

