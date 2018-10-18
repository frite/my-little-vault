import hashlib, re, string, itertools


for word in itertools.imap(''.join, itertools.product(string.lowercase, repeat=8)):
    if re.match(r'0+[eE]+\d+$', hashlib.md5(word).hexdigest()):
        print word

