import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head } from '@inertiajs/react';
import { Camera, Image as ImageIcon, Music, Zap, ZapOff, RefreshCcw, Timer, Sun, X } from 'lucide-react';
import { motion } from 'framer-motion';

export default function StoryCreator() {
    return (
        <AppLayout>
            <Head title="Story Creator - AmazamaHub" />

            <div className="max-w-md mx-auto h-[80vh] bg-black rounded-[40px] border border-gray-900 relative mt-4 overflow-hidden shadow-[0_0_100px_rgba(237,112,20,0.1)]">
                {/* Camera Feed Mock */}
                <div className="absolute inset-0 bg-gradient-to-br from-gray-900 to-black flex items-center justify-center">
                    <img src="https://images.pexels.com/photos/7915234/pexels-photo-7915234.jpeg?auto=compress&cs=tinysrgb&w=600" className="w-full h-full object-cover opacity-60 mix-blend-overlay" />
                    <p className="text-primary font-black italic text-xl animate-pulse tracking-widest">CAMERA ACTIVE</p>
                </div>

                {/* Top Controls */}
                <div className="absolute top-8 left-8 right-8 flex justify-between items-center z-10">
                    <button className="bg-black/40 backdrop-blur-md p-3 rounded-full hover:bg-black/60 transition"><X size={20} /></button>
                    <div className="bg-black/40 backdrop-blur-md px-4 py-2 rounded-full flex items-center space-x-3">
                        <Music size={16} className="text-primary" />
                        <span className="text-[10px] font-black italic tracking-widest">Add Sound</span>
                    </div>
                    <button className="bg-black/40 backdrop-blur-md p-3 rounded-full hover:bg-black/60 transition"><RefreshCcw size={20} /></button>
                </div>

                {/* Side Tools */}
                <div className="absolute top-1/2 -translate-y-1/2 right-6 flex flex-col space-y-6 z-10">
                    {[
                        { icon: <Zap size={22} />, label: 'Flash' },
                        { icon: <Timer size={22} />, label: 'Timer' },
                        { icon: <Sun size={22} />, label: 'Filters' },
                    ].map((tool, i) => (
                        <div key={i} className="flex flex-col items-center space-y-1 cursor-pointer group">
                            <div className="bg-black/40 backdrop-blur-md p-3 rounded-full group-hover:bg-primary/20 group-hover:text-primary transition duration-300 border border-white/5">
                                {tool.icon}
                            </div>
                            <span className="text-[8px] font-black uppercase tracking-widest opacity-60">{tool.label}</span>
                        </div>
                    ))}
                </div>

                {/* Bottom Bar */}
                <div className="absolute bottom-12 left-0 right-0 px-10 flex items-center justify-between z-10">
                    <div className="flex flex-col items-center space-y-1 cursor-pointer">
                        <div className="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 flex items-center justify-center"><ImageIcon size={24} /></div>
                        <span className="text-[8px] font-black uppercase tracking-widest">Upload</span>
                    </div>

                    <div className="relative group p-2">
                        <div className="w-20 h-20 rounded-full border-4 border-white/20 p-1 group-hover:scale-110 transition duration-500">
                            <div className="w-full h-full bg-white rounded-full active:scale-90 transition"></div>
                        </div>
                        <div className="absolute -top-4 left-1/2 -translate-x-1/2 bg-primary text-black text-[8px] font-black px-2 py-0.5 rounded uppercase tracking-tighter">Story</div>
                    </div>

                    <div className="flex flex-col items-center space-y-1 cursor-pointer">
                        <div className="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 flex items-center justify-center"><Sun size={24} /></div>
                        <span className="text-[8px] font-black uppercase tracking-widest">Effects</span>
                    </div>
                </div>

                {/* Mode Selector */}
                <div className="absolute bottom-4 left-0 right-0 flex justify-center space-x-6 z-10">
                    <span className="text-[10px] font-black italic text-white uppercase tracking-widest border-b-2 border-primary pb-1">Camera</span>
                    <span className="text-[10px] font-black italic text-gray-500 uppercase tracking-widest">Quick</span>
                    <span className="text-[10px] font-black italic text-gray-500 uppercase tracking-widest">Templates</span>
                </div>
            </div>
        </AppLayout>
    );
}
