#pragma once
//#include "txtfile.h"
//#include "DateStrings.h"
#include "PhpFile.h"

#define VERSION_LEN		6

class CDownloadFile :
	public CPhpFile
	//	public CTxtFile, public CDateStrings
{
public:
	CDownloadFile(void);
	~CDownloadFile(void);

	bool Modify(CString strPathName);

protected:
//	bool GetFileName(CString strPathName);
//	bool GetFileDate(CString strPathName);

	bool GetVersion();
	bool GetHardwareType();

	bool ModifyApi(bool bSnapshot, bool bChinese);
	bool ModifyBin(CString strChip, bool bChinese);

	bool ModifyFile(CString strFileName, CString strInsert);

	bool IsAR1688VoIPModule(CString strHardwareType);
	bool IsAR1688IpPhone(CString strHardwareType);
	bool IsPA1688IpPhone(CString strHardwareType);

	CString HardwareDisplayIpPhone(CString strHardwareType, bool bChinese);
	CString HardwareDisplayVoIPModule(CString strHardwareType, bool bChinese);

private:
//	CString m_strFileName;

/*
#define SOFT_VER_HIGH		0
#define SOFT_VER_LOW		6
#define SOFT_VER_BUILD		1
#define ENG_BUILD_HIGH		0
#define ENG_BUILD_MID		2
#define ENG_BUILD_LOW		4
*/
	int m_piVersion[VERSION_LEN];
	CString m_strVersion;
	CString m_strMainVersion;

	bool m_bProgrammerFile;

	CString m_strHardwareType;
	CString m_strProtocol;
	CString m_strLanguage;
	CString m_strOem;
};
