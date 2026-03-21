import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head } from '@inertiajs/react';
import { Shield, Lock, EyeOff, Bell, UserX, Key, ChevronRight, Info } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Privacy() {
    return (
        <AppLayout>
            <Head title="Privacy Center - AmazamaHub" />
            
            <div className="max-w-3xl mx-auto w-full py-12 px-4 pb-24 md:pb-12">
                <div className="flex items-center space-x-4 mb-12">
                     <div className="bg-blue-600/20 p-3 rounded-2xl text-blue-400">
                         <Shield size={32} />
                     </div>
                     <div>
                         <h1 className="text-3xl font-black italic tracking-tighter">Privacy Center</h1>
                         <p className="text-gray-500 font-medium text-sm mt-1">Control your data and how you appear to others.</p>
                     </div>
                </div>

                <div className="space-y-6">
                    {/* Public/Private Account */}
                    <div className="bg-gray-900/20 border border-gray-900 rounded-[32px] p-8 flex items-center justify-between">
                        <div className="flex items-center space-x-6">
                            <div className="p-4 bg-gray-800 rounded-2xl text-gray-400"><Lock size={24}/></div>
                            <div>
                                <p className="font-black italic text-lg">Private Account</p>
                                <p className="text-xs text-gray-500 font-medium max-w-xs">With a private account, only users you approve can follow you and watch your videos.</p>
                            </div>
                        </div>
                        <div className="w-14 h-8 bg-gray-800 rounded-full relative p-1 cursor-pointer">
                             <div className="w-6 h-6 bg-gray-600 rounded-full"></div>
                        </div>
                    </div>

                    {/* Section Grid */}
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {[
                            { title: 'Comment Privacy', icon: <MessageCircle size={18}/>, text: 'Choose who can comment' },
                            { title: 'Direct Messages', icon: <Bell size={18}/>, text: 'Filter message requests' },
                            { title: 'Blocked Users', icon: <UserX size={18}/>, text: 'Manage people you blocked' },
                            { title: 'Ad Settings', icon: <EyeOff size={18}/>, text: 'Personalize your ad experience' },
                        ].map((item, i) => (
                            <div key={i} className="bg-gray-900/10 border border-gray-900 rounded-[32px] p-6 flex items-center justify-between hover:bg-white/5 cursor-pointer transition group">
                                <div className="flex items-center space-x-4">
                                    <div className="p-3 bg-gray-800 rounded-xl text-gray-500 group-hover:text-primary transition">{item.icon}</div>
                                    <div className="space-y-0.5">
                                        <p className="font-black italic text-sm">{item.title}</p>
                                        <p className="text-[10px] text-gray-500 font-medium">{item.text}</p>
                                    </div>
                                </div>
                                <ChevronRight size={16} className="text-gray-800" />
                            </div>
                        ))}
                    </div>

                    {/* Security Footer */}
                    <div className="mt-12 bg-gradient-to-r from-gray-950 to-transparent p-10 rounded-[40px] border border-gray-900 flex items-start space-x-6">
                         <div className="p-4 bg-primary/10 rounded-2xl text-primary"><Info size={28}/></div>
                         <div className="space-y-2">
                             <h3 className="font-black italic text-lg uppercase tracking-widest text-gray-200">Our Privacy Promise</h3>
                             <p className="text-xs text-gray-500 font-medium leading-relaxed">We build privacy into every feature of AmazamaHub. We do not sell your personal information to third parties. Your trust is our most valuable asset.</p>
                         </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

// Missing import fix
import { MessageCircle } from 'lucide-react';
