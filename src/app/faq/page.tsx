"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import FAQ from "@/pages/FAQ";

export default function FAQPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <FAQ />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 