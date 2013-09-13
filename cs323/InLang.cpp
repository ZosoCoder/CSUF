#include <iostream>
#include <string>
#include <cctype>
using namespace std;

bool inLang(string w) {
	// Table representation of the FA for the language L= aa*b + bb*
	int fa[5][2] = { 1,2,
					 1,3,
					 4,2,
					 4,4,
					 4,4 };
	// Initialize state to start 
	int state = 0;
	int i = 0;
	// Iterate through word and follow states in fa.
	// If the character is valid, the state is updated. Otherwise, return false.
	while (i < w.length()) {
		switch(w[i]) { 
			case 'a':	// 'a' found
				state = fa[state][0];
				break;
			case 'b':	// 'b' found
				state = fa[state][1];
				break;
			default:	// invalid character found
				return false;
		}
		// Increment i for next character in word w
		i++;
	}
	// Return true if the word is a member of L= aa*b + bb*
	if (state == 2 || state == 3) return true;
	else return false;
}

int main(void) {
	// Variables for user input
	char ans;
	string word;

	do {
		// Get word from user
		cout << "Enter a string: ";
		getline(cin,word,'\n');
		// Evaluate word. Display result to user.
		if (inLang(word))
			cout << " '" << word << "' is a member of L= aa*b + bb*" << endl;
		else
			cout << " '" << word << "' is not a member of L= aa*b + bb*" << endl;
		// Prompt user to continue.
		cout << "CONTINUE(y/n)? ";
		cin >> ans;
		cin.ignore();
	} while (toupper(ans) == 'Y');

	return 0;
}
