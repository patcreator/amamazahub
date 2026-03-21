import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head } from '@inertiajs/react';
import { ShieldCheck, Target, Heart, EyeOff, AlertTriangle, Users, BookOpen, ChevronRight } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Safety() {
    return (
        <AppLayout>
            <Head title="Safety Center - AmazamaHub" />
            
            <div className="max-w-4xl mx-auto w-full py-12 px-4 pb-24 md:pb-12">
                <div className="text-center mb-16">
                    <div className="inline-flex items-center space-x-2 bg-green-500/10 text-green-400 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4 border border-green-500/20">
                        <ShieldCheck size={14} />
                        <span>Verified Safety Resources</span>
                    </div>
                    <h1 className="text-5xl font-black italic tracking-tighter mb-4 leading-tight">Trust & Safety at <span className="text-primary">AmazamaHub</span></h1>
                    <p className="text-gray-500 font-medium text-lg max-w-2xl mx-auto italic">We are committed to maintaining a safe and inclusive environment for our community.</p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {[
                        { title: 'Guardian\'s Guide', desc: 'Tools and resources for parents and caregivers.', icon: <Users className="text-blue-400" /> },
                        { title: 'Bullying Prevention', desc: 'How to handle harassment and stay safe.', icon: <Target className="text-red-400" /> },
                        { title: 'Digital Well-being', desc: 'Manage your time and content experience.', icon: <Heart className="text-pink-500" /> },
                    ].map((card, i) => (
                        <div key={i} className="bg-gray-900/20 border border-gray-900 p-8 rounded-[40px] space-y-4 hover:border-primary/30 transition cursor-pointer group">
                             <div className="bg-gray-800 p-4 rounded-3xl w-fit group-hover:scale-110 transition">{card.icon}</div>
                             <h3 className="text-xl font-black italic">{card.title}</h3>
                             <p className="text-xs text-gray-500 font-medium leading-relaxed">{card.desc}</p>
                             <button className="flex items-center space-x-2 text-[10px] font-black uppercase tracking-widest text-primary hover:underline pt-4">
                                 <span>Read More</span>
                                 <ChevronRight size={14} />
                             </button>
                        </div>
                    ))}
                </div>

                <div className="mt-12 space-y-4">
                    <h2 className="text-sm font-black uppercase tracking-widest text-gray-400 px-4">Safety Tools</h2>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                         {[
                             { title: 'Content Filtering', icon: <EyeOff size={18}/>, desc: 'Hide specific hashtags or keywords' },
                             { title: 'Report a Problem', icon: <AlertTriangle size={18}/>, desc: 'Flag suspicious or harmful content' },
                             { title: 'Community Guidelines', icon: <BookOpen size={18}/>, desc: 'Our rules for a safe community' },
                             { title: 'Safety Education', icon: <ShieldCheck size={18}/>, desc: 'Watch safety tips from our experts' },
                         ].map((tool, i) => (
                             <div key={i} className="flex items-center space-x-6 p-8 bg-gray-950/40 border border-gray-900 rounded-[40px] hover:bg-white/5 transition cursor-pointer group">
                                 <div className="p-4 bg-gray-900 rounded-2xl text-gray-500 group-hover:text-primary transition">{tool.icon}</div>
                                 <div>
                                     <p className="font-black italic text-sm">{tool.title}</p>
                                     <p className="text-[10px] text-gray-500 font-medium">{tool.desc}</p>
                                 </div>
                             </div>
                         ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
