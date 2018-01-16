#pragma once
class MyString
{
public:
	MyString();
	~MyString();

protected:
	void DebugString(CString str);
	CString AddDoubleQuotation(CString str);
	UINT ExecCmd(CString strCmd);
};

