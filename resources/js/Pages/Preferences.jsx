import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head } from '@inertiajs/react';
import { Settings2, Globe, Eye, Music, Languages, ChevronRight, Moon, Shield } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Preferences() {
    return (
        <AppLayout>
            <Head title="Content Preferences - AmazamaHub" />
            
            <div className="max-w-2xl mx-auto w-full py-12 px-4 pb-24 md:pb-12">
                <div className="flex items-center space-x-4 mb-12">
                     <div className="bg-primary/20 p-3 rounded-2xl text-primary">
                         <Settings2 size={32} />
                     </div>
                     <div>
                         <h1 className="text-3xl font-black italic tracking-tighter">Preferences</h1>
                         <p className="text-gray-500 font-medium text-sm mt-1">Personalize your AmazamaHub experience.</p>
                     </div>
                </div>

                <div className="space-y-4">
                    {[
                        { title: 'Video Language', icon: <Languages />, detail: 'English, Kinyarwanda, French' },
                        { title: 'Restricted Mode', icon: <Shield className="text-red-500" />, detail: 'Off' },
                        { title: 'Screen Time', icon: <Moon className="text-purple-400" />, detail: 'Daily limit: 2h' },
                        { title: 'Ad Personalization', icon: <Eye />, detail: 'Based on activity' },
                    ].map((item, i) => (
                        <div key={i} className="bg-gray-900/10 border border-gray-900 p-8 rounded-[40px] flex items-center justify-between hover:border-primary/40 cursor-pointer transition group">
                            <div className="flex items-center space-x-6">
                                <div className="p-4 bg-gray-800 rounded-2xl text-gray-400 group-hover:text-primary transition">{item.icon}</div>
                                <div>
                                    <p className="font-black italic text-lg">{item.title}</p>
                                    <p className="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Current: {item.detail}</p>
                                </div>
                            </div>
                            <ChevronRight size={20} className="text-gray-800" />
                        </div>
                    ))}
                </div>

                <div className="mt-12 p-8 bg-gray-950/40 border border-gray-900 rounded-[40px] flex items-start space-x-6">
                     <div className="p-4 bg-blue-600/10 rounded-2xl text-blue-400"><Globe size={28}/></div>
                     <div className="space-y-1">
                         <p className="text-[10px] font-black italic tracking-widest uppercase text-gray-300">Global Experience</p>
                         <p className="text-xs text-gray-500 font-medium leading-relaxed">Your content preferences affect what you see on the "For You" feed. You can reset your algorithm at any time in the settings.</p>
                     </div>
                </div>
            </div>
        </AppLayout>
    );
}
