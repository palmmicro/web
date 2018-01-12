#pragma once
#include "PhpFile.h"
class CImageFile :
	public CPhpFile
{
public:
	CImageFile();
	~CImageFile();

	bool Modify(CString strPathName, CString strTitle, CString strChineseTitle, CString strAltText);

protected:
	bool ModifyFile(CString strFileName, CString strInsert);
};

