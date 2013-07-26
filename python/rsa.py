#!/usr/bin/python
# -*- coding: cp1253 -*-
#-------------------------
#scripted by @frite
#ugghhh rsa calculations
#-------------------------
def findE(f):
    for e in range(2, f):
        if(euclid(f,e)==1) :
            a=e
            break
    return a


#Yo, function definition is here
def euclid(a,b):
    modulo=0			
    if(b==0) : return a
    while (b != 0) :
        if(a>=b):
            modulo=a%b
            a=b
            b=modulo
        else:
            modulo=b%a
            b=modulo
    return a

def findD(e,f):
    d=1
    while(1):
        if(((d*e)%f)==1):
           break
        d=d+1
    return d

def doEncryption(m,e,n):
    m=pow(m,e)
    m=m%n
    return m

def doDecryption(m,d,n):
    m=pow(m,d)
    m=m%n
    return m

p=input('give me p ')
q=input('give me q ')
n=p*q
print 'n is',n
f=(p-1)*(q-1)
print 'f(n) is ',f
e=findE(f)
print 'e is ',e
d=findD(e,f)
print 'd is ',d
m=input('Feed me a number to encrypt ')
m=doEncryption(m,e,n)
print 'Encrypted message is ',m
m=doDecryption(m,d,n)
print 'Decrypted message is ',m
