#pragma once
class WinSCP : public MyString
{
public:
	WinSCP();
	~WinSCP();

	void AddFile(CString strLocal, CString strRemote);
	int UpLoad(CString strExe, CString strScript, CString strLog, CString strDomain, CString strUserName, CString strPassword, int iEncryption);

	bool CheckLogFile(CString strLog);

protected:
	CString m_strPath;
	CStringList m_listScript;
	int m_iTotal;
};

