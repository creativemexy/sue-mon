"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Gifts from "@/pages/Gifts";

export default function GiftsPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Gifts />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 