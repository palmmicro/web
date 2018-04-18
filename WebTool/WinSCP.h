#pragma once
class WinSCP : public MyString
{
public:
	WinSCP();
	~WinSCP();

	bool AddFile(CString strLocal, CString strRemote);
	bool UpLoad(CString strExe, CString strScript, CString strLog, CString strDomain, CString strUserName, CString strPassword, int iEncryption);

protected:
	CString m_strPath;
	CStringList m_listScript;
};

