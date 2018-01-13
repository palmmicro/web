#pragma once
class WinSCP
{
public:
	WinSCP();
	~WinSCP();

	bool AddFile(CString strLocal, CString strRemote);
	bool UpLoad();
};

