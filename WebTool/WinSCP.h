#pragma once
class WinSCP
{
public:
	WinSCP();
	~WinSCP();

	bool AddFile(CString strLocal, CString strRemote);
	bool UpLoad(CString strExe, CString strScript, CString strLog);

protected:
	CString AddDoubleQuotation(CString str);
	UINT ExecCmd(CString strCmd);
};

