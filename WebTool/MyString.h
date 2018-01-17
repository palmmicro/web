#pragma once
class MyString
{
public:
	MyString();
	~MyString();

protected:
	void DebugString(CString str);
	void DebugStringList(CStringList & list);

	int ReplaceEscapeCharacter(CString & str);
	CString AddDoubleQuotation(CString str);
	UINT ExecCmd(CString strCmd);
};

